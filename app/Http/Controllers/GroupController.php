<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 12:34
 */

namespace Api\Http\Controllers;

use Api\Group;
use Api\Servers;
use Api\GroupServer;
use Illuminate\Http\Request;
use Api\Traits\RestHelperTrait;
use Api\Exceptions\RequestIsNotJson;
use Api\Http\Controllers\Controller;
use Api\Traits\RestSuccessResponseTrait;
use Api\Exceptions\GroupNotFoundException;
use Api\Exceptions\ServerNotFoundException;
use Api\Exceptions\ServerGroupExistException;
use Api\Exceptions\ServerGroupNotAssociatedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GroupController extends Controller
{
    use RestSuccessResponseTrait;
    use RestHelperTrait;

    /**
     * @param string $group
     * @return \Illuminate\Http\JsonResponse
     * @throws GroupNotFoundException
     */
    function Delete(string $group)
    {
        try {
            $Group = Group::where('slug', $group)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new GroupNotFoundException($group);
        }

        GroupServer::where('group_id', $Group->id)->delete();
        Group::where('slug', $group)->delete();

        return $this->jsonResponse();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function List()
    {
        $GroupList = Group::all();
        return $this->jsonResponse($GroupList);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws RequestIsNotJson
     */
    function Create(Request $request)
    {
        if (!$request->isJson())
            throw new RequestIsNotJson();

        $rules = config('ApiValidation.group.Create.rules');
        $messages = config('ApiValidation.group.Create.messages');

        $this->validate($request, $rules, $messages);

        $Group = new Group;
        $Group->slug = $request->input('slug');
        $Group->name = $request->input('name');
        $Group->saveOrFail();

        return $this->jsonResponse();
    }

    /**
     * @param string $group
     * @return \Illuminate\Http\JsonResponse
     */
    function ServerGroupList(string $group)
    {
        $GroupList = Group::with('Servers')->Group($group)->get();

        return $this->jsonResponse($GroupList);
    }

    function ServerAddGroup(Request $request, string $group, int $server_id)
    {
        try {
            $Group = Group::where('slug', $group)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new GroupNotFoundException($group);
        }

        try {
            $server = Servers::where('id', $server_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ServerNotFoundException($server_id);
        }
        if (GroupServer::Server($server_id)->first() != null)
            throw new ServerGroupExistException($server_id, $group);

        //  $GroupServer = new GroupServer;
        //  $GroupServer->server_id = $server->id;
        //  $GroupServer->group_id = $Group->id;
        // $GroupServer->saveOrFail();

        return $this->jsonResponse(null);
    }

    function ServerRemoveGroup(string $group, int $server_id)
    {
        try {
            $Group = Group::where('slug', $group)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new GroupNotFoundException($group);
        }

        try {
            $server = Servers::where('id', $server_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ServerNotFoundException($server_id);
        }

        $GroupServer = GroupServer::Server($server_id)->first();

        if ($GroupServer === null)
            throw new ServerGroupNotAssociatedException($server_id, $group);

        GroupServer::where('server_id', $server_id)->delete();

        return $this->jsonResponse(null);

    }
}
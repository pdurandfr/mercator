<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRouterRequest;
use App\Http\Requests\StoreRouterRequest;
use App\Http\Requests\UpdateRouterRequest;
use App\Router;
use App\NetworkSwitches;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RouterController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('router_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $routers = Router::all()->sortBy('name');

        return view('admin.routers.index', compact('routers'));
    }

    public function create()
    {
        abort_if(Gate::denies('router_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $network_switches = NetworkSwitches::all()->sortBy('name')->pluck('name', 'id');

        return view('admin.routers.create',compact('NetworkSwitches'));
    }

    public function store(StoreRouterRequest $request)
    {
        $router = Router::create($request->all());
        //$router->networkSwitches()->sync($request->input('networkSwitches', []));

        return redirect()->route('admin.routers.index');
    }

    public function edit(Router $router)
    {
        abort_if(Gate::denies('router_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $network_switches = NetworkSwitches::all()->sortBy('name')->pluck('name', 'id');

        return view('admin.routers.edit', compact('router','network_switches'));
    }

    public function update(UpdateRouterRequest $request, Router $router)
    {
        $router->update($request->all());
        //$router->networkSwitches()->sync($request->input('networkSwitches', []));

        return redirect()->route('admin.routers.index');
    }

    public function show(Router $router)
    {
        abort_if(Gate::denies('router_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.routers.show', compact('router'));
    }

    public function destroy(Router $router)
    {
        abort_if(Gate::denies('router_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $router->delete();

        return back();
    }

    public function massDestroy(MassDestroyRouterRequest $request)
    {
        Router::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
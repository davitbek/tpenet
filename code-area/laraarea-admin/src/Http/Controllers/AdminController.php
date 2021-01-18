<?php

namespace LaraAreaAdmin\Http\Controllers;

use LaraAreaAdmin\Services\AdminService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;

class AdminController extends Controller
{
    /**
     * @var bool
     */
    protected $isMakeDynamic = true;

    /**
     * @var
     */
    protected $serviceClass;

    /**
     * @var AdminService
     */
    protected $service;

    /**
     * @var
     */
    protected $resource;

    /**
     * @var
     */
    protected $viewRoot;

    /**
     * @var
     */
    protected $viewPath;

    /**
     * @var
     */
    protected $viewRootPrePath;

    /**
     * @var
     */
    private $classRootPath;

    /**
     * @var string
     */
    protected $layout = 'admin'; // @TODO

    /**
     *
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * AdminController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        if ($this->isMakeDynamic) {
            // firstly make service, resource, viewRoot
            $this->makeService();
            $this->makeResource();
            $this->makeViewRoot();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->service->paginate();
        foreach ($items as $item) {
            $item->imgUrl = $item->img_url;
        }
        $paths = $this->getViewPaths(__FUNCTION__);
        return view()->first($paths, ['items' => $items, 'resource' => $this->resource, 'layout' => $this->layout]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = $this->resource;

        $paths = $this->getViewPaths(__FUNCTION__);
        $formPartials = $this->getViewPaths('partials.form');
        return view()->first(
            $paths,
            compact('resource', 'formPartials')
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function store(Request $request)
    {
        $isCreated = $this->service->create($request->all());
        if ($isCreated) {
            flash('This ' . humanize($this->resource) . ' created successfully');
            $current = Route::currentRouteName();
            $current = str_replace('store', 'index', $current);
            return redirect()->route($current);
        }

        return $this->redirectBack();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->service->find($id);
        if (empty($item)) {
//            return $this->redirectTo(Str::singular(ucfirst($this->resource)) . ' not found !', 'index', __FUNCTION__);
        }
        $paths = $this->getViewPaths(__FUNCTION__);
        $showPartials = $this->getViewPaths('partials.show');
        return view()->first($paths, ['item' => $item, 'resource' => $this->resource, 'layout' => $this->layout, 'showPartials' => $showPartials]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->service->find($id);
        if (empty($item)) {
//            return $this->redirectTo(Str::singular(ucfirst($this->resource)) . ' not found !', 'index', __FUNCTION__);
        }
        $paths = $this->getViewPaths(__FUNCTION__);
        $formPartials = $this->getViewPaths('partials.form');
        return view()->first($paths, ['item' => $item, 'resource' => $this->resource, 'formPartials' => $formPartials]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function update(Request $request, $id)
    {
        $isUpdated = $this->service->update($id, $request->all());
        if ($isUpdated) {
            flash('This <a href="' . $request->url() . '">' . humanize($this->resource) . '</a> updated successfully');
            $message = 'updated';
            return $this->redirectTo($message, 'index', __FUNCTION__);
        }

        return $this->redirectBack();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = $this->service->delete($id);
        if ($isDeleted) {
            flash('Item deleted successfully', 'success');
            $message = 'deleted';
            return $this->redirectTo($message, 'index', __FUNCTION__);
        }

        $message = $this->service->getMessage();
        return $this->redirectBack(null, $message);
    }

    public function redirectTo($message, $action, $current)
    {
        $route = Route::currentRouteName();
        $route = str_replace($current, $action, $route);
        $routeParams = Route::current()->parameters();
        array_pop($routeParams);
        return redirect()->route($route, $routeParams)->with('error', $message);
    }

    public function redirectBack($validator = null, $message = null)
    {
        $message = $message ?? 'Please see errors';
        flash($message, 'danger');
        return redirect()->back()
            ->withErrors($this->service->getValidationErrorsErrors())
            ->withInput();
    }

    /**
     * @param $view
     * @return array
     */
    protected function getViewPaths($view)
    {
        $views = [
            $this->viewRoot . '.' . $this->getViewPath() . '.' . $view,
        ];

        $parts = explode('.', $this->viewRoot);
        $roots = [];
        foreach ($parts as $index => $part) {
            $roots[$index+1] = ! empty($roots[$index]) ? $roots[$index] . '.' . $part : $part;
        }
        rsort($roots);
        foreach ($roots as $root) {
            $views[] = $root . '.' . 'partials.crud.' . $view;
        }
        $views[] = 'partials.crud.' . $view;

        return $views;
    }

    /**
     * @return mixed
     */
    protected function getViewPath()
    {
        return $this->viewPath ?? $this->service->getTable();
    }

    /**
     * @throws \Exception
     */
    protected function makeService()
    {
        $className = $this->getServiceClass();
        if (! class_exists($className)) {
            $baseClassName = $this->getBaseServiceClass();
            throw new \Exception("Please make [$className] or [$baseClassName] class. @TODO CODE");
//            if (! class_exists($baseClassName)) {
//                throw new \Exception("Please make [$className] or [$baseClassName] class. @TODO CODE");
//            }
//
//            $className = $baseClassName;
        }

        $this->service = \App::make($className);
    }

    /**
     * @return mixed
     */
    public function getServiceClass()
    {
        $this->serviceClass = str_replace('Http\Controller', 'Service', get_class($this));
        $this->serviceClass = str_replace('Controller', 'Service', $this->serviceClass);
        return $this->serviceClass;
    }

    /**
     * @return mixed
     */
    public function getBaseServiceClass()
    {
        $serviceClass = str_replace('Http\Controller', 'Service', self::class);
        return  str_replace('Controller', 'Service', $serviceClass);
    }

    /**
     *
     */
    protected function makeResource()
    {
        if (empty($this->resource)) {
            if (! empty($this->service)) {
                $this->resource = $this->service->getResource();
            } else {
                $resource = basename(get_class($this));
                $resource = str_replace('Controller', '', $resource);
                $this->resource = lcfirst($resource);
            }
        }
    }

    /**
     *
     */
    protected function makeViewRoot()
    {
        if (empty($this->viewRoot)) {
            $this->viewRoot .= ($this->viewRootPrePath ? $this->viewRootPrePath . '.' : '')
                . lcfirst($this->getClassRootPath());
        }
    }

    /**
     * @return mixed
     */
    private function getClassRootPath()
    {
        if ($this->classRootPath) {
            return $this->classRootPath;
        }

        $class = get_class($this);
        $class = str_replace(config('laraarea_admin.namespaces.controller') . '\\', '', $class);
        $class = strtolower($class);
        $parts = explode('\\', $class);
        array_pop($parts);
        return $this->classRootPath = implode('.', $parts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUploadDefaultForm()
    {
        $resource = $this->resource;
        $uploadable = $this->service->getUploadable();
        $model = $this->service->getModel();
        $paths = $this->getViewPaths('default-upload');
        return view()->first(
            $paths,
            compact('resource', 'uploadable', 'model')
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function uploadDefault(Request $request)
    {
        $isUploaded = $this->service->storeDefaultUpload($request->all());
        flash('Default uploads successfully uploaded');
        return $this->redirectTo('success', 'index', 'update-upload-default');
    }
}

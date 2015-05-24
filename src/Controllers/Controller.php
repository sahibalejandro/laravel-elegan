<?php namespace Sahib\Elegan\Controllers;

use Illuminate\Routing\Controller as LaravelController;
use Request;
use Sahib\Elegan\Uploader\Uploader;

class Controller extends LaravelController
{

    /**
     * Primary key to search the resource.
     *
     * @var string
     */
    protected $key = 'id';

    /**
     * Views root.
     *
     * @var string
     */
    protected $viewsRoot = 'admin.resources';

    /**
     * Routes root.
     *
     * @var string
     */
    protected $routesRoot = 'admin.resources';

    /**
     * Repository instance.
     *
     * @var \Sahib\Elegan\Contracts\Repository
     */
    protected $repository;

    /**
     * Name for the variable to store the collection of resource within the view.
     *
     * @var string
     */
    protected $resources;

    /**
     * Name for the variable to store the resource within the view.
     *
     * @var string
     */
    protected $resource;

    /**
     * List resources.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $resources = $this->repository->paginate();

        return $this->view('index')->with([
            $this->resourcesName() => $resources
        ]);
    }

    /**
     * Show form for create a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->form();
    }

    /**
     * Store a new resource.
     *
     * @param \Sahib\Elegan\Uploader\Uploader $uploader
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Uploader $uploader)
    {
        $request = Request::instance();

        $uploader->moveFiles($request, $this->config());

        $resource = $this->repository->create($request->input());

        return redirect()->route($this->routeName('index'));
    }

    /**
     * Show form to edit a resource.
     *
     * @param mixed $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $resource = $this->repository->findByOrFail($this->key, $id);

        return $this->form($resource);
    }

    /**
     * Updates a resource.
     *
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $resource = $this->repository->findByOrFail($this->key, $id);

        $resource->update(Request::input());

        return back();
    }

    /**
     * Get the view to render.
     *
     * @param string $name
     * @return \Illuminate\View\View
     */
    protected function view($name)
    {
        return view($this->viewsRoot . '.' . $name);
    }

    /**
     * Get the name for the variable which represents a collection of resources
     * within the view.
     *
     * @return string
     */
    protected function resourcesName()
    {
        if (is_null($this->resources)) {
            $this->resources = str_plural($this->resolveResourcesName());
        }

        return $this->resources;
    }

    /**
     * Get the name for the variable which represents a resource
     * within the view.
     *
     * @return string
     */
    protected function resourceName()
    {
        if (is_null($this->resource)) {
            $this->resource = str_singular($this->resolveResourcesName());
        }

        return $this->resource;
    }

    /**
     * Resolve the resource name from the controller name.
     *
     * @return string
     */
    protected function resolveResourcesName()
    {
        return snake_case(preg_replace('/Controller$/', '', class_basename($this)));
    }

    /**
     * Show form for create/edit a resource.
     *
     * @param mixed|null $resource
     * @return \Illuminate\View\View
     */
    protected function form($resource = null)
    {
        // Define the form URL and method based on the existence of the resource.
        if (is_null($resource)) {
            $url = route($this->routeName('index'));
            $method = 'POST';
        } else {
            $key = $this->key;
            $url = route($this->routeName('show'), $resource->$key);
            $method = 'PATCH';
        }

        // If we found elegan configuration for the current resource then
        // the form will use files.
        $files = !is_null($this->config());

        // This is the view which will be included within the form layout.
        $formView = $this->routeName('form');

        // Options to use on the Form::model(...) call within the view.
        $formOptions = compact('url', 'method', 'files');

        return view('elegan::form-layout', [
            'resource' => $resource,
            'formOptions' => $formOptions,
            'formView' => $formView,
            // Bind the resource to a variable defined by the user.
            $this->resourceName() => $resource,
        ]);
    }

    /**
     * Get the full route name.
     *
     * @param string $route
     * @return string
     */
    protected function routeName($route)
    {
        return $this->routesRoot . '.' . $route;
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    protected function config($key = null)
    {
        if (!is_null($key)) {
            $key = ".$key";
        }

        return config('elegan.' . $this->resourceName() . $key);
    }
}

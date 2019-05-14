<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatetemplateRequest;
use App\Http\Requests\UpdatetemplateRequest;
use App\Repositories\templateRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class templateController extends Controller
{
    /** @var  templateRepository */
    private $templateRepository;

    public function __construct(templateRepository $templateRepo)
    {
        $this->middleware('auth');
        $this->templateRepository = $templateRepo;
    }

    /**
     * Display a listing of the template.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->templateRepository->pushCriteria(new RequestCriteria($request));
        $templates = $this->templateRepository->all();

        return view('templates.index')
            ->with('templates', $templates);
    }

    /**
     * Show the form for creating a new template.
     *
     * @return Response
     */
    public function create()
    {
        return view('templates.create');
    }

    /**
     * Store a newly created template in storage.
     *
     * @param CreatetemplateRequest $request
     *
     * @return Response
     */
    public function store(CreatetemplateRequest $request)
    {
        $input = $request->except('image');
        if ($request->hasFile('image'))
        {
            $photoName = rand(1,7257361) . time() . '.' . $request->image->getClientOriginalExtension();
            $mime = $request->image->getClientOriginalExtension();
            $request->image->move(public_path('avatars'), $photoName);
            $input['image'] = $photoName;
        }
        $template = $this->templateRepository->create($input);

        Flash::success('Template saved successfully.');

        return redirect(route('templates.index'));
    }

    /**
     * Display the specified template.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            Flash::error('Template not found');

            return redirect(route('templates.index'));
        }

        return view('templates.show')->with('template', $template);
    }

    /**
     * Show the form for editing the specified template.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            Flash::error('Template not found');

            return redirect(route('templates.index'));
        }

        return view('templates.edit')->with('template', $template);
    }

    /**
     * Update the specified template in storage.
     *
     * @param  int              $id
     * @param UpdatetemplateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatetemplateRequest $request)
    {
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            Flash::error('Template not found');

            return redirect(route('templates.index'));
        }
        $input = $request->except('image');
        if ($request->hasFile('image'))
        {
            $photoName = rand(1,7257361) . time() . '.' . $request->image->getClientOriginalExtension();
            $mime = $request->image->getClientOriginalExtension();
            $request->image->move(public_path('avatars'), $photoName);
            $input['image'] = $photoName;
        }
        $template = $this->templateRepository->update($input, $id);

        Flash::success('Template updated successfully.');

        return redirect(route('templates.index'));
    }

    /**
     * Remove the specified template from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $template = $this->templateRepository->findWithoutFail($id);

        if (empty($template)) {
            Flash::error('Template not found');

            return redirect(route('templates.index'));
        }

        $this->templateRepository->delete($id);

        Flash::success('Template deleted successfully.');

        return redirect(route('templates.index'));
    }
}

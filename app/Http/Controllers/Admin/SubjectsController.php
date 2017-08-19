<?php

namespace SiGeEdu\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use SiGeEdu\Forms\SubjectForm;
use SiGeEdu\Http\Controllers\Controller;
use SiGeEdu\Models\Subject;

class SubjectsController extends Controller
{

    private $subjectModel;
    private $formBuilder;

    public function __construct(Subject $subject, FormBuilder $formBuilder)
    {
        $this->subjectModel = $subject;
        $this->formBuilder = $formBuilder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = $this->subjectModel->paginate(5);
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->formBuilder->create(SubjectForm::class, [
            'url' => route('admin.subjects.store'),
            'method' => 'POST',
        ]);
        return view('admin.subjects.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $this->formBuilder->create(SubjectForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();
        $this->subjectModel->create($data);

        flash('Subject created with success!')->success()->important();
        return redirect()->route('admin.subjects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = $this->subjectModel->find($id);

        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $currentPage = $request->get('page');
        $subject = $this->subjectModel->find($id);

        $form = $this->formBuilder->create(SubjectForm::class, [
            'url'   => route('admin.subjects.update', ['subject' => $subject->id, 'page' => $currentPage]),
            'method' => 'PUT',
            'model' => $subject,
        ]);

        return view('admin.subjects.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currentPage = $request->get('page');
        $subject = $this->subjectModel->find($id);

        $form = $this->formBuilder->create(SubjectForm::class);

        if(!$form->isValid()){
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();
        $subject->update($data);

        flash('Subject changed with success!')->success()->important();
        return redirect(route('admin.subjects.index', ['page' => $currentPage]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = $this->subjectModel->find($id);
        $subject->delete();

        flash('User deleted with success!')->success()->important();
        return redirect()->route('admin.subjects.index');
    }
}

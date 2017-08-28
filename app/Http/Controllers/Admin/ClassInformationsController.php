<?php

namespace SiGeEdu\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use SiGeEdu\Http\Controllers\Controller;
use SiGeEdu\Models\ClassInformation;
use SiGeEdu\Forms\ClassInformationsForm;

class ClassInformationsController extends Controller
{
    private $classInformationModel;
    private $formBuilder;

    /**
     * ClassInformationsController constructor.
     *
     * @param ClassInformation $classinformation
     * @param FormBuilder $formBuilder
     */
    public function __construct(ClassInformation $classinformation, FormBuilder $formBuilder)
    {
        $this->classInformationModel = $classinformation;
        $this->formBuilder = $formBuilder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $class_informations = $this->classInformationModel->paginate(5);
        return view('admin.class_informations.index', compact('class_informations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->formBuilder->create(ClassInformationsForm::class, [
            'url' => route('admin.class_informations.store'),
            'method' => 'POST',
        ]);
        return view('admin.class_informations.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $this->formBuilder->create( ClassInformationsForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();
        $this->classInformationModel->create($data);

        flash('Class Informations created with success!')->success()->important();
        return redirect()->route('admin.class_informations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $class_information = $this->classInformationModel->find($id);

        return view('admin.class_informations.show', compact('class_information'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $currentPage = $request->get('page');
        $class_information = $this->classInformationModel->find($id);

        $form = $this->formBuilder->create(ClassInformationsForm::class, [
            'url'   => route('admin.class_informations.update', ['class_information' => $class_information->id, 'page' => $currentPage]),
            'method' => 'PUT',
            'model' => $class_information,
        ]);

        return view('admin.class_informations.edit', compact('form'));
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
        $class_information = $this->classInformationModel->find($id);

        $form = $this->formBuilder->create(ClassInformationsForm::class);

        if(!$form->isValid()){
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();
        $class_information->update($data);

        flash('Class Informations changed with success!')->success()->important();
        return redirect(route('admin.class_informations.index', ['page' => $currentPage]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class_information = $this->classInformationModel->find($id);
        $class_information->delete();

        flash('Class Informations deleted with success!')->success()->important();
        return redirect()->route('admin.class_informations.index');
    }
}

<?php

namespace SiGeEdu\Http\Controllers\Admin;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;
use SiGeEdu\Models\User;
use SiGeEdu\Forms\UserForm;
use SiGeEdu\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * UsersController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(5);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /** @var Form $form */
        $form = \FormBuilder::create(UserForm::class, [
            'url'       => route('admin.users.store'),
            'method'    => 'POST'
        ]);

        return view('admin.users.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        /** @var Form $form */
        $form = \FormBuilder::create(UserForm::class);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $user = $this->user->createFully($data);

        flash('User created with success!')->success()->important();
        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->find($id);
        //$user = $this->user->paginate();

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $currentPage = $request->get('page');
        $user = $this->user->find($id);

        /** @var Form $form */
        $form = \FormBuilder::create(UserForm::class, [
            'url'       => route('admin.users.update', ['user' => $user->id, 'page' => $currentPage]),
            'method'    => 'PUT',
            'model'     => $user
        ]);

        return view('admin.users.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currentPage = $request->get('page');
        $user = $this->user->find($id);

        /** @var Form $form */
        $form = \FormBuilder::create(UserForm::class, [
            'data'      => ['id' => $user->id]
        ]);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $user->update($data);

        flash('User changed with success!')->success()->important();
        return redirect(route('admin.users.index', ['page' => $currentPage]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        $user->delete();

        flash('User deleted with success!')->success()->important();
        return redirect()->route('admin.users.index');
    }
}

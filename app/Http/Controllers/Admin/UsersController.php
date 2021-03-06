<?php

namespace SiGeEdu\Http\Controllers\Admin;

use FormBuilder;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;
use Password;
use function PHPSTORM_META\type;
use SiGeEdu\Models\User;
use SiGeEdu\Forms\UserForm;
use SiGeEdu\Http\Controllers\Controller;
use SiGeEdu\Notifications\UserCreated;

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
        $form = FormBuilder::create(UserForm::class, [
            'url'       => route('admin.users.store'),
            'method'    => 'POST'
        ]);

        return view('admin.users.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var Form $form */
        $form = FormBuilder::create(UserForm::class);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $result = $this->user->createFully($data);

        $user = $result['user'];
        $password = $result['password'];

        if (isset($data['send_notification'])){
            $token = Password::broker()->createToken($user);
            $user->notify(new UserCreated($token));
        }

        $request->session()->flash('user_created', [
            'id' => $user->id,
            'password' => $password
        ]);

        flash('User created with success!')->success()->important();
        return redirect(route('admin.users.show_details'));
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
        return view('admin.users.show', compact('user'));
    }


    /**
     * Display the details for specified resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDetails(){
        $userData = session('user_created');

        $user = $this->user->findOrFail($userData['id']);
        $user->password = $userData['password'];

        return view('admin.users.show_details', compact('user'));
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
        $form = FormBuilder::create(UserForm::class, [
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
        $form = FormBuilder::create(UserForm::class, [
            'data'      => ['id' => $user->id]
        ]);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();

        if ( $this->typeChanged($data, $user) ){
            $user->userable()->delete();
        }

        $user->assignEnrolment($user, $data['type']);
        $user->assignRole($user, $data['type']);
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

    /**
     * Checks if the 'type' field has changed.
     *
     * @param array $data
     * @param User $user
     * @return bool
     */
    private function typeChanged(array $data, User $user)
    {
        $types = [
            User::ROLE_ADMIN   => \SiGeEdu\Models\Administrator::class,
            User::ROLE_TEACHER => \SiGeEdu\Models\Teacher::class,
            User::ROLE_STUDENT => \SiGeEdu\Models\Student::class,
        ];

        $result = ($data['type'] <> implode('', array_keys($types, $user->userable_type))) ? true : false;
        return $result;
    }
}

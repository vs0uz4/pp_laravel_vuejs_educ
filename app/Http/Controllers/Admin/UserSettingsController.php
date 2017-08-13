<?php

namespace SiGeEdu\Http\Controllers\Admin;

use Auth;
use FormBuilder;
use Kris\LaravelFormBuilder\Form;
use SiGeEdu\Forms\UserSettingsForm;
use SiGeEdu\Http\Controllers\Controller;

class UserSettingsController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        /** @var Form $form */
        $form = FormBuilder::create(UserSettingsForm::class,[
            'url' => route('admin.users.settings.update'),
            'method' => 'PUT'
        ]);

        return view('admin.users.settings', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        /** @var Form $form */
        $form = FormBuilder::create(UserSettingsForm::class);

        if (!$form->isValid()){
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();
        $data['password'] = bcrypt($data['password']);
        Auth::user()->update($data);

        flash('Password changed with success!')->success()->important();
        return redirect()->route('admin.users.settings.edit');
    }
}
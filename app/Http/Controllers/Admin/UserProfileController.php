<?php

namespace SiGeEdu\Http\Controllers\Admin;

use FormBuilder;
use Kris\LaravelFormBuilder\Form;
use SiGeEdu\Forms\UserProfileForm;
use SiGeEdu\Http\Controllers\Controller;
use SiGeEdu\Models\User;

class UserProfileController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        /** @var Form $form */
        $form = FormBuilder::create(UserProfileForm::class, [
            'url' => route('admin.users.profile.update', ['user' => $user->id]),
            'method' => 'PUT',
            'model' => $user->profile,
            'data' => ['user' => $user]
        ]);

        return view('admin.users.profile.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param User $user
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(User $user)
    {
        /** @var Form $form */
        $form = FormBuilder::create(UserProfileForm::class);

        if (!$form->isValid()){
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();
        $user->profile->address ? $user->profile()->update($data) : $user->profile()->create($data);

        flash('Profile changed with success!')->success()->important();
        return redirect()->route('admin.users.profile.update', ['user' => $user->id]);
    }
}

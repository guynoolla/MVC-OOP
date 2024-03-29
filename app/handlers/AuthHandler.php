<?php

namespace App\Handlers;

use App\Repository\UserR;
use App\Repository\UserCUD;
use App\Core\Form;
use App\Models\UserModel;

class AuthHandler extends Handler
{
    public function login(Form $form)
    {
        $this->renderer->render('auth/login', [
            'form' => $form
        ]);
    }

    public function loginForm(UserR $userR, Form $form)
    {
        $email = $form->input('email');
        $password = $form->input('password');

        $user = $userR->findByEmail($email, ['passwordHash', 'id']);

        if (!$user || !password_verify($password, $user->attr('passwordHash'))) {
            $errors[] = 'Неверный эл. адрес или пароль.';
            $this->renderer->render('auth/login', ['errors' => $errors]);
        } else {
            $this->session->set('logged_in_user', $user->attr('id'));
            $this->redirect('/');
        }
    }

    public function register(Form $form)
    {
        $form->fromSession('register_form', $this->session);

        $this->renderer->render('auth/register', [
            'form' => $form
        ]);
    }

    public function registerForm(UserR $userR, UserCUD $userCUD, Form $form)
    {
        $form->validate($userR, UserModel::validationRules());

        if ($form->validationPassed()) {
            $user = new UserModel($form->inputAll());
            $userCUD->save($user);
            $this->session->set('success', 'Регистрация прошла успешно!');
            $this->redirect('/');

        } else {
            $form->intoSession('register_form', $this->session);
            $this->redirect('auth/register');
        }
    }

    public function logout()
    {
        $this->session->clear();
        $this->redirect('/');
    }
}

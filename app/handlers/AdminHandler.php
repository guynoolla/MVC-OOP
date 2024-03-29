<?php

namespace App\Handlers;

use App\Models\PostModel;
use App\Repository\PostR;
use App\Repository\PostCUD;
use App\Core\Form;

class AdminHandler extends Handler
{
    public function editForm(PostR $postR, PostCUD $postCUD,  Form $form, $config) {
        $params = $this->params();

        if ($form->validate($postR, PostModel::validationRules())) {
            
        }

        if ($form->validationPassed()) {
            echo 'Form validation passed!';
            $post = new PostModel($form->inputAll());
            pr($post);
        } else {
            $form->getErrors();
        }
    }

    public function edit(Form $form) {
        $this->renderer->render('admin/post/edit', [
            'form' => $form
        ]);
    }
}

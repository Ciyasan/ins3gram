<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Recipe extends BaseController
{
    protected $breadcrumb = [['text' => 'Tableau de Bord', 'url' => '/admin/dashboard']];
    public function index()
    {
        $this->addBreadcrumb('Recettes', "");
        return $this->view('admin/recipe/index');
    }

    public function create()
    {
        helper('form');
        $this->addBreadcrumb('Recettes', "/admin/recipe");
        $this->addBreadcrumb('Création d\'une recette', "");
        $users = Model('UserModel')->findAll();
        return $this->view('admin/recipe/form', ['users' => $users]);
    }
    public function edit($id_recipe)
    {
        helper('form');
        $this->addBreadcrumb('Recettes', "/admin/recipe");
        $this->addBreadcrumb('Modification d\'une recette', "");
        $recipe = Model('RecipeModel')->find($id_recipe);
        if (!$recipe) {
            $this->error('Recette introuvable');
            return $this->redirect('/admin/recipe');
        }
        $users = Model('UserModel')->findAll();
        return $this->view('admin/recipe/form', ['users' => $users, 'recipe' => $recipe]);
    }

    public function insert()
    {
        $data = $this->request->getPost();
        $rm = Model('RecipeModel');
        if ($rm->insert($data)) {
            $this->success('Recette créée avec succès !');
        } else {
            foreach ($rm->errors() as $error) {
                $this->error($error);
            }
        }
        return $this->redirect('/admin/recipe');
    }

    public function switchActive()
    {
        $id = $this->request->getPost('id_recipe');
        $recipeModel = model('RecipeModel');

        // Récupérer la recette (même s'il est soft deleted)
        $recipe = $recipeModel->withDeleted()->find($id);

        if (!$recipe) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Recette introuvable'
            ]);
        }

        if ($recipe->isActive()) {
            // Désactiver la recette (soft delete)
            $recipeModel->delete($id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Recette désactivée',
                'status' => 'inactive'
            ]);
        } else {
            // Réactiver avec la méthode restore
            if ($recipeModel->reactive($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Recette activée',
                    'status' => 'active'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur lors de l\'activation'
                ]);
            }
        }
    }
}

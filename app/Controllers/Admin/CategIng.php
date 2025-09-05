<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CategIng extends BaseController
{
    public function index()
    {
        helper('form');
        $categ = Model('CategIngModel')->orderBy('name', 'ASC')->findAll();
        return $this->view('admin/categ-ing', ['categ' => $categ]);
    }
    public function update()
    {
        //
    }
    public function insert()
    {
        $cim = model('CategIngModel');
        $data = $this->request->getPost();
        if (empty($data['id_categ_parent'])) unset($data['id_categ_parent']);
        if ($cim->insert($data)) {
            $this->success('Catégorie d\'ingrédient bien créée');
        } else {
            foreach ($cim->errors() as $error) {
                $this->error($error);
            }
        }
        return $this->redirect('admin/category-ingredient');
    }
    public function delete()
    {
        //
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Brand extends BaseController
{
    public function index()
    {
        helper('form');
        return $this->view('admin/brand');
    }

    public function insert()
    {
        $bm = model('BrandModel');
        $data = $this->request->getPost();
        if ($bm->insert($data)) {
            $this->success('Marque bien créée');
        } else {
            foreach ($bm->errors() as $error) {
                $this->error($error);
            }
        }
        return $this->redirect('admin/brand');
    }

    public function update()
    {
        $bm = model('BrandModel');
        $data = $this->request->getPost();
        $id = $data['id'];
        unset($data['id']);
        if ($bm->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => "La marque à été modifiée avec succés !",
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $bm->errors(),
            ]);
        }
    }

    public function delete()
    {
        $bm = model('BrandModel');
        $id = $this->request->getPost('id');
        if ($bm->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => "La marque à été supprimée avec succés !",
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $bm->errors(),
            ]);
        }
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\DataTableTrait;

class RecipeModel extends Model
{

    use DataTableTrait;
    protected $table            = 'recipe';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'alcool', 'id_user'];
    protected $beforeInsert = ['setInsertValidationRule', 'validateAlcool'];
    protected $beforeUpdate = ['setUpdateValidationRule', 'validateAlcool'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected function setInsertValidationRule(array $data)
    {
        $this->validationRules = [
            'name'    => 'required|max_length[255]|is_unique[recipe.name]',
            'alcool'  => 'permit_empty|in_list[0,1,on]',
            'id_user' => 'permit_empty|integer',
            'description' => 'permit_empty',
        ];
        return $data;
    }

    protected function setUpdateValidationRule(array $data)
    {
        $id = $data['data']['id_recipe'] ?? null;
        $this->validationRules = [
            'name'    => 'required|max_length[255]|is_unique[recipe.name,id,$id]',
            'alcool'  => 'permit_empty|in_list[0,1,on]',
            'id_user' => 'permit_empty|integer',
            'description' => 'permit_empty',
        ];
        return $data;
    }


    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom de la recette est obligatoire.',
            'max_length' => 'Le nom de la recette ne peut pas dépasser 255 caractères.',
            'is_unique'  => 'Cette recette existe déjà.',
        ],
        'alcool' => [
            'in_list' => 'Le champ alcool doit être 0 (sans alcool) ou 1 (avec alcool).',
        ],
        'id_user' => [
            'integer' => 'L’ID de l’utilisateur doit être un nombre.',
        ],
    ];


    protected function validateAlcool(array $data)
    {
        $data['data']['alcool'] = isset($data['data']['alcool']) ? 1 : 0;
        return $data;
    }

    /**
     * Réactive un utilisateur soft deleted
     */
    public function reactive(int $id): bool
    {
        return $this->builder()
            ->where('id', $id)
            ->update(['deleted_at' => null, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    protected function getDataTableConfig(): array
    {
        return [
            'searchable_fields' => [
                'name',
                'description',
                'alcool',
                'user.name'
            ],
            'joins' => [
                [
                    'table' => 'user',
                    'condition' => 'user.id = recipe.user_id',
                    'type' => 'left'
                ]
            ],
            'select' => 'recipe.*, user.name as creator_name',
            'with_deleted' => true
        ];
    }
}

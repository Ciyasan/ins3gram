<?php

namespace Tests\Feature\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

final class RecipeControllerTest extends CIUnitTestCase
{
  use DatabaseTestTrait;
  use FeatureTestTrait;
  protected $migrate = true;
  protected $refresh = true;
  protected $DBGroup = 'tests';
  protected $namespace = 'App';
  protected $seed = 'App\Database\Seeds\MasterSeeder';

  public function testOneRecipePageLoads()
  {
    $result = $this->get('/recette/mojito');

    $result->assertStatus(200);
    $result->assertSee('Mojito');
    $result->assertSee('Cocktail cubain rafraîchissant à base de rhum, menthe et citron vert');
  }

  public function testAllRecipesPageLoads()
  {
    $result = $this->get('/recette');

    $result->assertStatus(200);
    $result->assertSee('Liste des recettes');
    $result->assertSeeElement('#add-ingredient');
  }

  public function testWithOrWithoutAlcoholFilter()
  {
    $resultWithAlcohol = $this->get('/recette?alcool=1');
    $resultWithoutAlcohol = $this->get('/recette?alcool=0');

    $resultWithAlcohol->assertStatus(200);
    $resultWithAlcohol->assertSee('Liste des recettes');
    $resultWithAlcohol->assertSee('Mojito');
    $resultWithAlcohol->assertDontSee('Virgin Cuba Libre');

    $resultWithoutAlcohol->assertStatus(200);
    $resultWithoutAlcohol->assertSee('Liste des recettes');
    $resultWithoutAlcohol->assertSee('Virgin Cuba Libre');
    $resultWithoutAlcohol->assertDontSee('Mojito');
  }

  public function testSortByName()
  {
    $resultAsc = $this->get('/recette?sort=name');
    $resultDesc = $this->get('/recette?sort=name_desc');

    $resultAsc->assertStatus(200);
    $resultAsc->assertSee('Liste des recettes');
    $resultAsc->assertSeeInOrder(['Bloody Mary', 'Gin Tonic', 'Mojito', 'Virgin Cuba Libre']);

    $resultDesc->assertStatus(200);
    $resultDesc->assertSee('Liste des recettes');
    $resultDesc->assertSeeInOrder(['Virgin Cuba Libre', 'Mojito', 'Gin Tonic', 'Bloody Mary']);
  }
}

<?php

namespace app\Controller\Admin\Categories;

use app\Controller\controller;
use app\Model\Categories\Category;
use app\Model\Model;
use framework\Request\Request;

class Categories extends controller
{
    function categoriesView(){

        $this->view(CategoriesController."Categories");
    }
    function CategoryGetById(Request $request){
        $CatModel=new Category();
        $CatModel->get($request->id);
        if ($CatModel->next()){
            $CatModel->Data=array(
                "Id"=>$CatModel->id,
                "Category"=>$CatModel->Name,
                "Uri"=>$CatModel->URI,
                "Description"=>$CatModel->Description
            );
            $CatModel->Message="Category Found";

            $CatModel->Success=true;
            $CatModel->Code=200;
        }else{
            $CatModel->Success=false;
            $CatModel->Message="No Category Found";
            $CatModel->Code=404;
        }

        $CatModel->Json();
    }
    function CategoriesGet(Request $request){
        $CatModel=new Category();
        $CatModel->GetCategories($request->values["from"]);
    }
    function CategoryInsert(Request $request){
        $CatModel=new Category();
        $this->fillData($request,$CatModel);
        if($CatModel->InsertCategory()){
            $CatModel->Message="inserted Successfully";
        }else{
            $CatModel->Message="SomeThing Went Wrong ";
        }
        $CatModel->Json();
    }
    function CategoryUpdate(Request $request){
        $CatModel=new Category();
        $this->fillData($request,$CatModel);
        $CatModel->update("id=".$request->id);
        $CatModel->Json();
    }
    function CategoryDelete(Request $request){
        $CatModel=new Category();
        $CatModel->id=$request->id;
        $CatModel->delete();
        $CatModel->Success=true;
        $CatModel->Json();
    }
    function fillData(Request &$From, Model &$To)
    {
        parent::fillData($From, $To);
        $To->Name=$From->values["Category"];
        $To->URI=$From->values["Uri"];
    }

}
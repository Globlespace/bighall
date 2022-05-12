<?php


namespace app\Model\Images;


use app\Model\Model;
use app\Model\ProductType\product_type;

class Image extends Model
{
    function GetProImage($from){
        $query="select * from ".$this->table." ORDER BY id desc limit ".$from.",10;";
        $this->query($query);
        while ($this->next()){
            $ProModel=new product_type();
            $ProModel->get("Id",$this->ProType_id);

            $ProModel->next();
            ?>
            <div class="tr">
                <div id="Id" name="id"><?=$this->Id?></div>
                <div id="Image" name="Image"><img  width="100" src="<?=UP_IMAGES.$this->Image?>" alt="No Image"></div>
                <div id="Image" name="Image"><?=$ProModel->Name?></div>
                <div class="relative">
                    <button data-title="Update your changes" onclick="EditData(<?=$this->Id?>)" class="updaterow btn btn-outline-primary">
                        <i class="fa fa-pencil-square-o"></i>
                    </button>
                    <button data-title="Click to Delete" onclick="Delete(<?=$this->Id?>)" class="delete btn btn-outline-danger">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
            <?php
        }

    }
    function InsertProImage(){

        $this->insert();
        if($this->mysql_error_no==1062){
            $this->Message="Image is already in Database";

        }else{
            $this->Message="Image Uploaded Successfully";
        }
    }
}
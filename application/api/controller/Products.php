<?php


namespace app\api\controller;
use app\common\controller\Api;
use think\Db;
use think\Config;
use think\Exception;

/**
*Created by Tangkoan
*/
class Products extends Api{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
    * sproducts function
    */   
    public function sproducts(){
        $id = (int) $this->request->post('id');
        if(!$id) {
            return $this->error(__("No ID"));
        }
        
        try {
            $data = Db::name("products")->where("id",$id)->select();
            $this->success(__('Success'),  $data);
        } catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }

    public function delete(){
        $id = (int) $this->request->delete('id');
        if(!$id) {
            return $this->error(__("Please Input ID"));
        }
        try {
            $data = Db::name("products")->where("id", $id)->delete();
            $this->success(__('success'),  $data);
        } catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }

    public function addproduct() {
        // Retrieve POST data
        $id = $this->request->post('id');
        $title = $this->request->post('title');
        $description = $this->request->post('description');
        $short_description = $this->request->post('short_description');
        $image = $this->request->post('image');
        $images = $this->request->post('images');
        $status = (int)$this->request->post('status');
        $type_id = (int) $this->request->post('type_id');
        $categories_id = (int) $this->request->post('categories_id');
        $createtime = $this->request->post('createtime');
        $updatetime = $this->request->post('updatetime');
        $price = (int)$this->request->post('price');
        $discount_price = (int)$this->request->post('discount_price');
        $conditioin = $this->request->post('conditioin'); // Corrected variable name
    
        // Check if any required field is missing
        $missing_required = (($id && $title) && (($short_description && $image) && ($status && $type_id))) && (($categories_id && $price) && (/*$discount_price &&*/ $conditioin)); 
    
        // Check if any optional field is present
        $any_optional_present = ($description || $createtime) || ($updatetime || $images);

        // Prepare the data for insertion
        if (!$missing_required) {
            return $this->error(__(">>> Please fill all the required fields."));
        } else {
            $data = [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'short_description' => $short_description,
                'image' => $image,
                'images' => $images,
                'status' => $status,
                'createtime' => $createtime,
                'updatetime' => $updatetime,
                'type_id' => $type_id,
                'categories_id' => $categories_id,
                'price' => $price,
                'discount_price' => $discount_price,
                'conditioin' => $conditioin // Corrected variable name
            ];
            try {
                // Insert the data into the 'products' table
                $result = Db::name("products")->insert($data);
    
                // Check if the insert was successful
                if ($result) {
                    return $this->success(__('Product added successfully.'), $data);
                } else {
                    return $this->error(__('Failed to add product.'));
                }
            } catch (Exception $e) {
                return $this->error(__('Error occurred: ') . $e->getMessage());
            }
        }
    }
    
    public function updateproduct() {
        // Get post data
        $id = $this->request->post('id');
        $title = $this->request->post('title');
        $description = $this->request->post('description');
        $short_description = $this->request->post('short_description');
        $image = $this->request->post('image');
        $images = $this->request->post('images');
        $status = $this->request->post('status');
        $type_id = (int) $this->request->post('type_id');
        $categories_id = (int) $this->request->post('categories_id');
        $price = (int) $this->request->post('price');
        $discount_price = (int) $this->request->post('discount_price');
        $conditioin = $this->request->post('conditioin');
        $updatetime = time();
    
        // Check required fields
        $missing_required = (($id && $title) && (($short_description && $image) && ($status && $type_id))) && (($categories_id && $price) && (/*$discount_price &&*/ $conditioin));

    
        if (!$missing_required) {
            return $this->error(__("Required fields missing"));
        }
    
        try {
            // Update product data

            $data = Db::name('products')
                ->where("id", $id)
                ->update([
                    'title' => $title,
                    'description' => $description,
                    'short_description' => $short_description,
                    'image' => $image,
                    'images' => $images,
                    'status' => $status,
                    'updatetime' => $updatetime,
                    'type_id' => $type_id,
                    'categories_id' => $categories_id,
                    'price' => $price,
                    'discount_price' => $discount_price,
                    'conditioin' => $conditioin
                ]);
    
            // // Check if the update was successful
            if ($data  === 0) {
                // throw new Exception("");
                return $this->error(__("Update failed"), );
            }
            $newData = Db::name('products')->where('id',$id )->find();
            // // Return success response
            return $this->success(__('Update successful'), $newData);
        } catch (Exception $e) {
            // Handle errors
            return $this->error(__('Update failed'), $e->getMessage());
        }
    }
    
}
?>
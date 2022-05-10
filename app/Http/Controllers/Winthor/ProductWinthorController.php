<?php

namespace App\Http\Controllers\Winthor;

use DB;
use Image;
use config;
use Validator;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Attribute;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use App\Models\Childcategory;
use App\Models\AttributeOption;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class ProductWinthorController extends Controller
{

    /**
     * getAll Product from win Thor API
     *
     * @return void
     */
    public function getAll()
    {

        $sign = Currency::where('is_default','=',1)->first();


        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();


        // Call WinThor Api
        $url = config('winthor.winthor_url').'api/Pcprodut/Xecomm/S';
      //  $token = config('winthor.token');

        $response = Http::withToken($token)->get($url);

        $resultTable = $this->getTableResultHead();

        if ($response->status() == 200) {

            foreach ($response->object() as $item) {

                // clear variables
                $description    = '';
                $fileName       = '';

                $description    = $this->generateProductDescription($item);

                $fileName       = $this->copyProductImage($item->xpathpic);

                $exists_product = Product::where('sku','=',$item->codprod)->first();

                if (!$exists_product){
                    // Save Data
                    $product = $this->saveProduct($item, $fileName, $description);

                    $this->updateSlugAndThumbnail($product);

                    $resultTable .= $this->insertTableResultProduct($product, 'Importado');

                }else{
                    $resultTable .= $this->insertTableResultProduct($exists_product, 'Não Importado, Produto Já Existe no Banco');
                }



            }
        }

        $resultTable .= $this->getTableResultFooter();


        return view('admin.product.import')->with('resultTable', $resultTable);
    }



    /**
     * getOne Product from win Thor API
     *
     * @return void
     */
    public function getOne()
    {


        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();

        $id = 12;
        $url = config('winthor.winthor_url').'api/Pcprodut/'.$id;
       // $token = config('winthor.token');

        $response = Http::withToken($token)->get($url);

        if ($response->status() == 200) {

            $description    = $this->generateProductDescription($response->object());
            $fileName       = $this->copyProductImage($response->object()->xpathpic);

            // Save Data
            $product = $this->saveProduct($response->object(), $fileName, $description);

            $this->updateSlugAndThumbnail($product);

        }

    }

    /**
     * saveProduct
     *
     * @param Object $item
     * @param String $fileName
     * @param Text $description
     * @return Object $product
     */
    private function saveProduct($item, $fileName = '',  $description = '')
    {
        $ProductModel = new Product;

        // pegar o id mysql do manufact_id pelo $item->codmarca

        echo '<pre>';
            print_r($item);
        echo '</pre>';

        $productDB = array (
            'user_id'               => 0,
            'category_id'           => 4,
            'product_type'          => 'normal',
            'type'                  => 'Physical',
            'sku'                   => $item->codprod,
            'name'                  => $item->descricao,
            'photo'                 => $fileName,
            'details'               => $description,
            'price'                 => 0,
            'stock'                 => 1,
            'status'                => 1,
            'product_condition'     => 2, // 2: new, 1: used
            'manufact_id'           => $item->codmarca,
        );

        // Save Data and return product inserted
        return $ProductModel->create($productDB);

    }



    /**
     * updateSlugAndThumbnail
     *
     * @param mixed $response
     * @return void
     */
    private function updateSlugAndThumbnail($product)
    {
        // Set SLug
        if($product->type != 'Physical'){
            $product->slug = Str::slug($product->name,'-').'-'.strtolower(Str::random(3).$product->id.Str::random(3));
        }
        else {
            $product->slug = Str::slug($product->name,'-').'-'.strtolower($product->sku);
        }

        if (!empty($product->photo)) {

            if(Storage::exists($product->photo)){
                // Set Thumbnail
                $img = Image::make(public_path().'/assets/images/products/'.$product->photo)->resize(285, 285);
                $thumbnail = Str::random(10).'.jpg';
                $img->save(public_path().'/assets/images/thumbnails/'.$thumbnail);
                $product->thumbnail  = $thumbnail;
            }else{

                $product->thumbnail  = $product->photo;
            }

        }



        // update slug and Thumbnail
        $product->update();

        return;
    }

    /**
     * copyProductImage
     *
     * @param  $image_url
     * @return $fileName
     */
    private function copyProductImage($image_url)
    {

        $fileName = '';

        if (!empty($image_url)) {
            $img = explode('/',$image_url);

            $fileName = end($img);

        }

        return $fileName;
    }

    /**
     * generateProductDescription
     * Gera uma tabela html com a descrição e demais informações do Produto
     * @param  mixed $item
     * @return string $descrpiton
     */
    private function generateProductDescription($item)
    {

        echo '<pre>';
            print_r($item);
        echo '</pre>';

        $description = "<table class='table  table-striped'>
            <tbody>
                <tr>
                    <td>Código</td>
                    <td>{$item->codprod}</td>
                </tr>
                <tr>
                    <td>Marca</td>
                    <td>".@$item->marca."</td>
                </tr>
                <tr>
                    <td>Fabricante</td>
                    <td>{$item->codfab}</td>
                </tr>
                <tr>
                    <td>Embalagem</td>
                    <td>{$item->embalagem}</td>
                </tr>
                <tr>
                    <td>Unidade Medida</td>
                    <td>{$item->unidade}</td>
                </tr>
                <tr>
                    <td>Peso Bruto</td>
                    <td>{$item->pesobruto}</td>
                </tr>
                <tr>
                    <td>Peso líquido</td>
                    <td>{$item->pesoliq}</td>
                </tr>
                <tr>
                    <td>Informações Técnicas</td>
                    <td>{$item->informacoestecnicas}</td>
                </tr>
                <tr>
                    <td>Outras Informações</td>
                    <td>".@$item->descricao4."</td>
                </tr>
            </tbody>
        </table>";

        return $description;
    }




    /**
     * getTableResultHead
     * Gera parte da tabela html com resultado da importação
     * @return string $table
     */
    private function getTableResultHead()
    {

        $table = "<table class='table  table-bordered'>

            <thread>
                <tr>
                    <th>Cód</th>
                    <th>Descrição</th>
                    <th>Status</th>
                </tr>
            </thread>
            <tbody>";

         return $table;

    }

    /**
     * getTableResultHead
     * Gera parte da tabela html com resultado da importação
     * @param  Object $product
     * @return string $table
     */
    private function insertTableResultProduct($product, $status)
    {

        $table = "<tr>
                    <td>{$product->sku}</td>
                    <td>{$product->name}</td>
                    <td>$status</td>
                </tr>";

        return $table;
    }



    /**
     * getTableResultHead
     * Gera parte da tabela html com resultado da importação
     * @return string $table
     */
    private function getTableResultFooter()
    {

        $table = "</tbody>
                </table>";

         return $table;

    }

}

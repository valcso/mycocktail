<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Helpers\CategoryHelper;
use App\Http\Requests\StoreProductRequest;
use App\Models\ExtrafieldCategory;
use App\Models\Extrafields;
use App\Models\Logs;
use App\Models\Manufacturers;
use App\Models\ProductCategoryGlue;
use App\Models\ProductExtrafieldGlue;
use App\Models\ProductFiles;
use App\Models\Products;
use App\Models\ProductSeo;
use App\Objects\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Szykra\Notifications\Flash;
use View;

class ProductsController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
     public function allProducts(Request $request)
    {
        $manufacturers = new Manufacturers();
       if($request->has('filterSubmitted'))
        {
            $cai=$request->input('filter_cai');
            $naziv=$request->input('filter_naziv');
            $za_prodaju=$request->input('filter_za_prodaju');
            $proizvodjac=$request->input('filter_proizvodjac');
            $opterecenje=$request->input('filter_opterecenje'); 
            $brzinski=$request->input('filter_brzinski');
            $kategorija=$request->input('filter_kategorija');
            $sirina=$request->input('filter_sirina');
            $visina=$request->input('filter_visina');
            $precnik=$request->input('filter_precnik');
            $dimenzije=$request->input('filter_deminzije');
            $oznaka=$request->input('filter_oznaka');
            $potrosnja=$request->input('filter_potrosnja');
            $prijanjanje=$request->input('filter_prijanjanje');
            $buka=$request->input('filter_buka');
            $garancija=$request->input('filter_garancija');
            $sezona=$request->input('filter_sezona');
            $dezen=$request->input('filter_dezen');
            $slika=$request->input('filter_slika');
            $tezina=$request->input('filter_tezina');
            $zemlja=$request->input('filter_zemlja');
            $runflat=$request->input('filter_runflat');
            $ean=$request->input('filter_ean');
            $sku=$request->input('filter_sku');

            $query = \DB::table('products');
            
            if(!empty($cai)){$query->where( 'product_code', 'like', '%' . $cai. '%');}
            if(!empty($naziv)){$query->where( 'name', 'like', '%' . $naziv. '%');}
            if(!empty($za_prodaju)){$query->where(  'forsale', 'like', '%' . $za_prodaju. '%');}
            if(!empty($proizvodjac)){$query->where(  'ef_proizvodjac', 'like', '%' . $proizvodjac. '%');}
            if(!empty($opterecenje)){$query->where(  'ef_opterecenje', 'like', '%' . $opterecenje. '%');}
            if(!empty($brzinski)){$query->where(  'ef_brzinski', 'like', '%' . $brzinski. '%');}
            if(!empty($kategorija)){$query->where(  'ef_kategorija', 'like', '%' . $kategorija. '%');}
            if(!empty($sirina)){$query->where(  'ef_sirina', 'like', '%' . $sirina. '%');}
            if(!empty($visina)){$query->where(  'ef_visina', 'like', '%' . $visina. '%');}
            if(!empty($precnik)){$query->where(  'ef_precnik', 'like', '%' . $precnik. '%');}
            if(!empty($dimenzije)){$query->where(  'ef_dimensions', 'like', '%' . $dimenzije. '%');}
            if(!empty($oznaka)){$query->where(  'ef_oznaka', 'like', '%' . $oznaka. '%');}
            if(!empty($potrosnja)){$query->where( 'ef_potrosnja', 'like', '%' . $potrosnja. '%');}
            if(!empty($prijanjanje)){$query->where( 'ef_prijanjanje', 'like', '%' . $prijanjanje. '%');}
            if(!empty($buka)){$query->where(  'ef_buka', 'like', '%' . $buka. '%');}
            if(!empty($garancija)){$query->where(  'ef_garancija', 'like', '%' . $garancija. '%');}
            if(!empty($sezona)){$query->where(  'ef_sezona', 'like', '%' . $sezona. '%');}
            if(!empty($dezen)){$query->where(  'ef_dezen', 'like', '%' . $dezen. '%');}
            if(!empty($slika)){$query->where(  'image', 'like', '%' . $slika. '%');}
            if(!empty($tezina)){$query->where(  'ef_tezina', 'like', '%' . $tezina. '%');}
            if(!empty($zemlja)){$query->where(  'ef_zemlja', 'like', '%' . $zemlja. '%');}
            if(!empty($runflat)){$query->where(  'ef_runflat', 'like', '%' . $runflat. '%');}
            if(!empty($ean)){$query->where(  'ean', 'like', '%' . $ean. '%');}
            if(!empty($zemlja)){$query->where(  'ef_zemlja', 'like', '%' . $zemlja. '%');}
            if(!empty($sku)){
                $sku=str_replace("ipg","",$sku);
                $query->where( 'id',$sku);
            }
    

            $query->groupBy('product_code');
            $data['products'] = $query->get();
            $data['filterSearch']='true';
       
        }
      else 
        {  
            $req = $request->all();
            if(isset($req['page'])) {
                unset($req['page']);
            }
    
            $manufacturers = new Manufacturers();
            $data['manufacturers'] = $manufacturers->getAllActiveSelectBox();
    
            //$data['extrafields'] = Extrafields::all();
    
            if(!empty($req)) {
                $data['products'] = Products::serachProducts($request->all());
            } else {
                $data['products'] = Products::getAllWithThumbs();
                $data['products']->appends(\Input::except('page'));
                $data['products']->setPath(\URL::current());
            }
    
       }
        return view('admin.pages.products.index_products', $data);
    }


    /**
     * @return \Illuminate\View\View
     */
    public function createProduct()
    {
       // $extrafields = new ExtrafieldCategory();
        $manufacturers = new Manufacturers();

        $data = array();
        $data['manufacturers'] = $manufacturers->getAllActiveSelectBox();
        //$data['extrafields'] = $extrafields->getByCats([1]);
        return view('admin.pages.products.new_product', $data);
    }


    /**
     * @param $id
     * @return \Illuminate\View\View
     */

    public function editProduct($id, $section = '')
    {
        $product = new Product();
        $product->init(['id' => $id]);

        switch ($section) {
            case 'categories':
                $data['data'] = $this->editCategory($product);
                $data['template'] = '_categories';
                break;
            case 'extrafields':
                $data['data'] = $this->editExtrafields($product);
                $data['template'] = '_extrafields';
                break;

            case 'prices':
                $data['template'] = '_prices';
                break;
            case 'images':
                $data['data'] = $this->editImages($product);
                $data['template'] = '_images';
                break;
            case 'seo':
                $data['data']['seo'] = ProductSeo::where('product_code', '=', $product->product_code)->first();
                $data['template'] = '_seo';
                break;
            case 'gifts':
                $data['template'] = '_gifts';
                break;

            case 'parameters':
                $data['template'] = '_parameters';
                break;

            case 'similar':
                $data['template'] = '_similar';
                break;
            default:
                $Manufacturers = new Manufacturers();
                $data['template'] = '_details';
                $data['data']['manufacturers'] = $Manufacturers->getAllActiveSelectBox();
        }

        /* Accessible data through views */
        $data['data']['product'] = $product->item->toArray();

        View::share('product', $data['data']['product']);
        return view('admin.pages.products.edit_product', $data);
    }


    /**
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProductDetails(StoreProductRequest $request)
    {
        $product = new Products();
        $id = $product->updateProductDetails($request->all());
       
        $name=$request->input('name');
       $this->updateProductDescription($name,$id,$type='description');

        \Flash::success(trans('admin.msg_success_updated'));
        return redirect()->to('admin/products/edit/' . $id);
    
    }

    public function updateProductDescription ($id,$proizvodjac,$dezen,$sezona,$dimenzija,$type)

    {
        $product = Products::where('id',$id)->get();
        if($type='parameters')
        {

          
          $short_description_proizvodjac=ucwords(strtolower($proizvodjac));
          $description = '';
          $short_description=$short_description_proizvodjac." ".$dezen;
          
          if($sezona == 'za sve sezone')
          {
              $description = "Guma za sve sezone ".''.$proizvodjac.' '.$dezen.' u dimenziji '.$dimenzija.' sa garancijom od 36 meseci, dostupna je uz besplatnu isporuku na adresu vašeg vulkanizera.';
          }
          else 
          {
            $sezona = ucwords(strtolower($sezona));
            $description =  $sezona.' guma '.$proizvodjac.' '.$dezen.' u dimenziji '.$dimenzija.' sa garancijom od 36 meseci, dostupna je uz besplatnu isporuku na adresu vašeg vulkanizera.';

          }
        }
        
        Products::where('id',$id)->update(['desc' => $description,'short_desc'=>$short_description]);
    
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateParameters(Request $request)
    {
        $product = new Product(true, ['id' => $request->id]);

        foreach($request->all() AS  $field => $value){
            if(\Str::startsWith($field, 'ef_'))
            {
                $product->setField($field, $value);
            }
        }

       $id=$request->id;
       $proizvodjac = $request->input('ef_proizvodjac');
       $dezen = $request->input('ef_dezen');
       $sezona = $request->input('ef_sezona');
       $dimenzija = $request->input('ef_dimensions');
       $type='parameters';
       
       $this->updateProductDescription($id,$proizvodjac,$dezen,$sezona,$dimenzija,$type);
   

        \Flash::success(trans('admin.msg_success_updated'));
         return redirect()->to('admin/products/edit/' .$request->id.'/parameters');
    }


    /**
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insertProduct(StoreProductRequest $request)
    {
        $product = new Products();
        $id = $product->createProduct($request->all());

        

        \Flash::success(trans('admin.msg_success_added'));
        return redirect()->to('admin/products/edit/' . $id);
    }

    /**
     *
     */
    public function activate()
    {
        // Object validation system !!!!
        //$valid = \App\Validators\ProductValidator::check();
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $product_code
     */
    public function updateProductCategories($id, Request $request)
    {
        $result = Products::select('product_code')->where('id', $id)->first();

        \DB::table('product_category_glue')->where('product_code', '=', $result['product_code'])->delete();
        $post = $request->all();

        if (!empty($post['category'])) {
            foreach ($post['category'] AS $cat) {
                \DB::table('product_category_glue')->insert(['product_code' => $result['product_code'], 'category_id' => $cat]);
            }
        }

        return redirect()->to('admin/products/edit/' . $id . '/categories');
    }

    public function updateProductPrice($id, Request $request)
    {
        Products::where('id', $id)
            ->update(['list_price' => $request->list_price, 'price' => $request->price, 'free_shipping' => $request->free_shipping]);
        return redirect()->to('admin/products/edit/' . $id . '/prices');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProductSeo($id, Request $request)
    {
        $productSeo = ProductSeo::firstOrCreate(['product_code' => $request->product_code]);

        $productSeo->product_code = $request->product_code;
        $productSeo->title = $request->meta_title;
        $productSeo->keywords = $request->meta_keywords;
        $productSeo->description = $request->meta_description;
        $productSeo->save();

        \Flash::success(trans('admin.msg_success_updated'));
        return redirect()->to('admin/products/edit/' . $id . '/seo');
    }

    /**
     *
     */
    public function updateProductExtrafields($id, Request $request)
    {
        foreach($request->extrafield AS $key => $ef)
        {
            if($ef == '') { continue; }

            if($ef != '@')
            {
                $peg = ProductExtrafieldGlue::firstOrNew(['product_code' => $request->pcode, 'extrafield_id' => $key]);
                $peg->product_code = $request->pcode;
                $peg->extrafield_id = $key;
                $peg->value = $ef;
                $peg->save();


            } else {
                ProductExtrafieldGlue::where('product_code', $request->pcode)->where('extrafield_id', $key)->delete();
            }
        }

        // Update searchable dimension field
        ProductExtrafieldGlue::updateDimensions($request->pcode);

        \Flash::success(trans('admin.msg_success_updated'));
        return redirect()->to('admin/products/edit/' . $id . '/extrafields');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function saveImages(Request $request)
    {
        $files = $request->file('files');
        $product = new Product();
        $product->init(['product_code' => $request->product_code]);
        $product->saveImages($files);

        \Flash::success(trans('admin.images_added'));
        return \Redirect::to('admin/products/edit/'.$product->item->id.'/images');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImages(Request $request)
    {
        $productFiles = new ProductFiles();
        $productFiles->updateFile($request->all());
        \Flash::success(trans('admin.images_updated'));
        return redirect()->to($request->url('/'));
    }


#######################################################
###### Mass edit methods
########################################################

    /**
     * @param Request $request
     * @return View
     */
    public function massEdit(Request $request)
    {
        /* Service buttons - Clone, Delete, Export, */
        if ($request->action && $request->selector)
        {
            switch ($request->action)
            {
                case 'clone_product':
                    foreach ($request->selector as $pcode => $value) {
                        $product = new Product(true, ['product_code' => $pcode]);
                        $id = $product->cloneProduct();
                        unset($product);
                        Flash::success('Uspešno kloniran proizvod');
                        return redirect(url('/admin/products/edit/'.$id));

                    }
                    break;
                case 'delete':
                    $deletedProducts = '';
                    foreach ($request->selector as $pcode => $value) {
                        $product = new Product(true, ['product_code' => $pcode]);
                        $product->deleteProduct();
                        $deletedProducts .= $pcode.', ';
                        unset($product);
                    }
                    Flash::success('Obrisani proizvodi : '.$deletedProducts);
                    return redirect(url('/admin/products'));
                    break;

                case 'export_selected':
                    $exportController = new ExportController();
                    $exportController->exportProducts(array_keys($request->selector));
                    Flash::success('Exportovani proizvodi : '.implode(', ', array_keys($request->selector)));
                    return redirect( url('admin/export'));
                    break;
            }

            //return redirect(route('Admin.list_products'));
        }


            \Assets::add(url('/js/admin/mass.js'));
            $Manufacturers = new Manufacturers();

            $data = array();
            $data['post'] = $request->all();

            $categories = Category::all(array('name'))->toArray();
            $itemsHelper = new CategoryHelper($categories);

            $data['category_render'] = $itemsHelper->renderProductHtml($categories, true, array());
            $data['manufacturers'] = $Manufacturers->getAllActive();
            $data['products'] = Products::whereIn('product_code', array_keys($data['post']['selector']))->get();
            //$data['extrafields'] = Extrafields::all();

            return view('admin.pages.products.mass_edit_products', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function massEditStore(Request $request)
    {
        if($request->action === "ispravka"){
            $cais = array_keys($request->products);
            $user = \Auth::user()->name;
            $prev = Logs::select('selector','old','new')
                ->where('Model', 'Products')
                ->whereIn('selector', $cais)
                ->latest()->get()->groupBy('selector')->toArray();
            $products = [];
            foreach($prev as $cai => $arrays){
                $olds[$cai] = json_decode($arrays[0]['new'], true);
                $news[$cai] = json_decode($arrays[0]['old'], true);
                $products[] = new Product(true, ['product_code' => $cai]);
            }
            for($i=0; $i<count($cais); $i++){
                $products[$i]->setField('price', $news[$cais[$i]]['price']);
                $data['model'] = 'Products';
                $data['selector'] = $cais[$i];
                $data['old'] = json_encode($olds[$cais[$i]]);
                $data['new'] = json_encode($news[$cais[$i]]);
                $data['user'] = $user;
                Logs::createLog($data);
            }
            $request->request->add(['selector' => $request->products]);
            return $this->massEdit($request);
        }
        else{
            //selecting data thats about to be modified for the "old" column in the log
            $olds = Products::select('product_code', 'price', 'list_price')->whereIn('product_code', array_keys($request->products))->get()->toArray();
            foreach($olds as &$old){
                unset($old['realPrice']);
            }
            $products = array();
            $files = $request->file('files');
            foreach($request->products AS  $pcode => $p)
            {
                $products[] = new Product(true, ['product_code' => $pcode]);
            }

            if($request->nivelacija != 0){
                $niv = 1 + $request->nivelacija/100;
                foreach($products as $product){
                    $newPrice = floor($product->item->price*$niv).".00";
                    $product->setField('price', $newPrice);
                }
            }
            foreach( $request->all() AS $field => $value)
            {

                // Insert into products table
                if(in_array($field, \Schema::getColumnListing('products')))
                {
                    foreach($products AS $product)
                    {
                        $product->setField($field, $value);
                    }
                }


                // Other inserts
                switch ($field)
                {
                    case "files":
                        foreach($products AS $product)
                        {
                            $product->saveMassImages([$files], true);
                            unset($product);
                        }
                        break;
                    case "meta_title":
                    case "meta_keywords":
                    case "meta_description":
                        foreach($products AS $product)
                        {
                            $product->setSeoField(str_replace('meta_', '', $field), $value);
                        }
                        break;
                    case "ef":
                        foreach($products AS $product)
                        {
                            foreach($value AS $k => $e)
                            {
                                $product->setExtrafieldValue($k, $e);
                            }
                            $product->generateDimensionExtrafield();
                        }
                        break;

                    case "category":
                        $reset = (isset($value['reset'])) ? 1 : 0;
                        if($reset){
                            unset($value['reset']);
                        }
                        foreach($products AS $product)
                        {
                            if($reset) {
                                ProductExtrafieldGlue::where('product_code', $product->item->product_code)->delete();
                            }
                            foreach($value AS $pcg) {
                                $r = ProductCategoryGlue::firstOrCreate(array('product_code' => $product->item->product_code, 'category_id' => $pcg));
                            }
                        }
                        break;
                }
            }
            //changed data for logging in the "new" column
            $news = Products::select('product_code', 'price', 'list_price')->whereIn('product_code', array_keys($request->products))->get()->toArray();
            foreach($news as &$new){
                unset($new['realPrice']);
                $new = json_encode($new);
            }
            if(count($olds) === count($news)){
                $user = \Auth::user()->name;
                for($i=0; $i<count($olds); $i++){
                    $data['model'] = 'Products';
                    $data['selector'] = $olds[$i]['product_code'];
                    $data['old'] = json_encode($olds[$i]);
                    $data['new'] = $news[$i];
                    $data['user'] = $user;
                    Logs::createLog($data);
                }
            }

        }
        \Flash::success(trans('admin.updated_success'));
        return redirect( url('admin/products'));
    }



#######################################################
###### Private parts for "editProduct" method
#######################################################
    /**
     * Edit product's categories
     * @param $product
     * @internal param $product_id
     */
    private function editCategory($product)
    {
        $categories = Category::all(array('name'))->toArray();
        $itemsHelper = new CategoryHelper($categories);

        $data['productCategories'] = $product->getCategories($product->item->product_code);

        $data['render'] = $itemsHelper->renderProductHtml($categories, true, $data['productCategories']);

        if (empty($categories)) {
            unset($data['render']);
        }

        return $data;
    }

    /**
     * Edit product's extrafields
     * @param $product
     * @internal param $product_id
     */
    private function editExtrafields($product)
    {
        $ProductExtrafieldGlueObject = new ProductExtrafieldGlue();
        $Extrafields = new Extrafields();

        $data['product_extrafields'] = $ProductExtrafieldGlueObject->prepareProductEf($product->item->product_code);
        $data['extrafields'] = $Extrafields->getDiffForProduct($product->item->product_code);

        return $data;
    }

    /**
     * @param $product
     * @return mixed
     */
    private function editImages($product)
    {
        $data['files'] = $product->getAllFiles(true);
        return $data;
    }

######################################################
###### Search products
######################################################

    /**
     * @param Request $request
     * @return $this
     */
    public function searchProducts(Request $request)
    {
       $products = Products::all()->paginate(100);
        return \Redirect::route('Admin.list_products')
           ->with('products' , $products)
           ->withInput();
    }
}



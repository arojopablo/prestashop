<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class categoriaproductos extends Module
{
    public function __construct()
    {
        $this->name = 'categoriaproductos';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Pablo Rojo';
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->displayName = $this->l('categoriaproductos');
        $this->description = $this->l('Muestra un carousel con los productos de una categoría específica');
    }
    
    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayHome');
    }
    
    public function uninstall()
    {
        return parent::uninstall();
    }
    
    public function hookdisplayHeader($params) {
        $this->context->controller->registerStylesheet('modules-categoriaproductos', 'modules/'.$this->name.'/css/categoriaproductos.css', ['media' => 'all', 'priority' => 150]);
    }
    
    public function write_to_console($data) {
        $console = $data;
        if (is_array($console))
        $console = implode(',', $console);
       
        echo "<script>console.log('Console: " . $console . "' );</script>";
       }
      
    public function write_to_consolePro($data) {
        $console = 'console.log(' . json_encode($data) . ');';
        $console = sprintf('<script>%s</script>', $console);
        echo $console;
       }
      
    public function getCategoryById($categoryid)
        {
          $categoryid = 13; // en este ejemplo se setea la variable en la categoria '13' de manera estatica.
          $sql = "SELECT link_rewrite FROM `ps_category_lang` WHERE id_category = $categoryid LIMIT 1";
          $this->write_to_console($sql);
      return Db::getInstance()->executeS($sql);
       }
    
    // public function getImageIdByProductId($productid) {
    //     $sql = "SELECT id_image FROM `ps_image` WHERE id_product = 31 LIMIT 1";
    //     return Db::getInstance()->executeS($sql);
    // }

    public function hookDisplayHome($params)
    {
        $categoryId = 13; // Cambia este número por el ID de la categoría que quieres mostrar
        $category = new Category($categoryId);
        $products = Product::getProducts(Context::getContext()->language->id, 0, 0, 'date_upd', 'ASC', $categoryId, true);
        $category_link=$this->getCategoryById($categoryId);
      

        $id_product = 23;
 
// lenguaje id
$id_lang = (int) Configuration::get('PS_LANG_DEFAULT');
 
// Get cover image de un producto
$image = Image::getCover($id_product);
 
// Load Product Object
$product = new Product($id_product);
 
// Initializaciones
$link = new Link;
 
$imagePath = $link->getImageLink($product->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'home_default');
$imagePath = "http://".$imagePath;
echo $imagePath;


        $this->context->smarty->assign([
            'products' => $products,
            'category' => $category_link,
            'image' => $imagePath
        ]);

        
        // $this->write_to_console("productos: ");
         $this->write_to_consolePro($products);
         $this->write_to_consolePro($category_link);
        // $this->write_to_consolePro($category);
        return $this->display(__FILE__, 'views/templates/hook/categoriaproductos.tpl');
    }
}

?>
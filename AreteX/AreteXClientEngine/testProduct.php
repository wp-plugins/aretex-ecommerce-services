<? 
include('Product.class.php');

$prod = new Product();
$prod->id = 1;
$prod->code = 'Code';
$prod->details->pricing->single_price('19.95');
$prod->details->pricing->single_price('15.96','20D');
echo '<pre>';
var_dump($prod);
echo "\n--\n";
$str = $prod->toJSON();
echo "\n$str\n";
$obj = Product::fromJSON($str);
var_dump($obj);

echo '</pre>';

?>
App/Models

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'full_name',
        'slug',
    ];

    public function orders(){
        return $this->hasMany('App\Orders','user_id');
    }

   public function merchants(){
        return $this->hasMany('App\Merchants','admin_id');
    }
}


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'merchant_id',
        'price',
        'status',
        'created_at',
    ];

    public function merchants(){
       return $this->belongsTo('App\Merchants');
   }

    public function order_items(){
        return $this->hasMany('App\Order_items','product_id');
    }
}


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'status',
        'created_at',
    ];

    public function users(){
        return $this->belongsTo('App\Users');
   }

   public function order_items(){
    return $this->hasMany('App\Order_items','order_id');
}

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders_items extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];

    public function orders(){
       return $this->belongsTo('App\Orders');
    }

    public function products(){
        return $this->belongsTo('App\Products');
   }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchants extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'merchant_name',
        'created_at',
        'admin_id',
    ];

   public function users(){
       return $this->belongsTo('App\Users');
    }
   public function products(){
        return $this->hasMany('App\Products','merchant_id');
    }

}

------------------------------------------------------------------------------------
Database\Migrations
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('slug');
            $table->timestamps();

        });
    }
    public $timestamps = false;
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_name');
            $table->foreignId('admin_id')->constrained()->onDelet('cascade');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelet('cascade');
            $table->string('status');
            $table->string('created_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained()->onDelet('cascade');
            $table->foreignId('product_id')->constrained()->onDelet('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('merchant_id')->constrained()->onDelet('cascade');
            $table->integer('price');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
------------------------------------------------------------------------------------------------
Database\Seeders

<?php

namespace Database\Seeders;
use App\Models\Users;
use App\Models\Merchants;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Orders_items;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\var;
use Illuminate\Support\date;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Faker::create();

        foreach(range(1,50) as $index){

        DB::table('Users')->insert([

        'id' => $faker->numerify('#####'),
        'full_name' => $faker->name,
        'slug' => $faker->sentence(10),
        'created_at' => $faker->dateTimeBetween(' 1643742679000', '1646075479')


            ])
        ;
    }
}
}
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1,50) as $index){

        DB::table('Products')->insert([

            'id' => $faker->numerify('##########'),
            'name' => $faker->name,
            'merchant_id' => $faker->numerify('##########'),
            'price' => $faker->numerify('###'),
            'status' => $faker->sentence(10),
            'created_at' => $faker->dateTimeBetween(' 1643742679000', '1646075479')


            ])
        ;
    }
}
}
class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        foreach(range(1,50) as $index){
        DB::table('Orders')->insert([

            'id' => $faker->numerify('##########'),
            'user_id' => $faker->numerify('##########'),
            'status' => $faker->sentence(10),
            'created_at' => $faker->dateTimeBetween(' 1643742679000', '1646075479')


            ])
        ;
    }
}
}
class Order_itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1,50) as $index){

        DB::table('Order_items')->insert([

          'order_id' => $faker->numerify('##########'),
          'product_id' =>$faker->numerify('##########'),
          'quantity' => $faker->numerify('###'),


          ])
      ;
  }
}
}
class MerchantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1,50) as $index){

        DB::table('Merchants')->insert([

       'id' => $faker->numerify('#########'),
       'merchant_name' => $faker->name,
       'created_at' => $faker->dateTimeBetween('1643742679000', '1646075479'),
       'admin_id' =>$faker->numerify('#########'),
       ])
       ;
   }
}
}
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
         MerchantsSeeder::class,
         Order_itemsTableSeeder::class,
         OrdersTableSeeder::class,
         ProductsTableSeeder::class,
         UsersTableSeeder::class,
        ]);
    }
}
---------------------------------------------------------------------------------------------------------
<?php

namespace App\Http\Controllers;
use App\Models\Merchants;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Order_items;
use App\Models\Users;
use Illuminate\Http\Request;
use DB;
use App\Post;
use Auth;

class DateRangeController extends Controller
{
    public function index()
    {
        $products = DB::Table('products')->select('name','price')->where('id',1)->get();
        return view('daterange')->with('products');
    }
}
    public function fetch_data(Request $request)
    {
     if($request->ajax())
     {
      if($request->from_created_at != '' && $request->to_created_at != '')
      {
       $data = DB::table('Products')
         ->whereBetween('created_at', array($request->from_created_at, $request->to_created_at))
         ->get();
      }
      else
      {
       $data = DB::table('Products')->orderBy('created_at', 'desc')->get();
      }
      return json_encode($data);
     }
    }
}
-------------------------------------------------------------------------------------------------------
Route::get('data', [DateRangeController::class, 'index'])->name('search');
Route::post('products', [DateRangeController::class, 'getProducts'])->name('products');

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
--------------------------------------------------------------------------------------------------------
views
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
    </html>
    </head>
 <body>
  <div class="container">
     <br />
     <h3 aligne="center">Task done by Alaa Alfawaka to EXASystems</h3>
     <br />
            <br />
            <div class="row input-daterange">
                <div class="col-md-4">
                    <P>From</P><input class="form-control mr-sm-2" type="Date" placeholder="Date" aria-label="Date">
                </div>
                <div class="col-md-4">
                    <P>To</P><input class="form-control mr-sm-2" type="Date" placeholder="Date" aria-label="Date">
                </div>
                <div class="col-md-4">
                    <P>Day</P><input class="form-control mr-sm-2" type="Sunday" placeholder="Sunday" aria-label="Sunday">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-success">Filter</button>
                    <button>
                        <span class="glyphicon glyphicon-download"></span>
                        Download list
                     </button>
                </div>
            </div>
            <br />
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <button class="dropdown-item" type="button">Add</button>
                  <button class="dropdown-item" type="button">Edit</button>
                  <button class="dropdown-item" type="button">Delet</button>
                  <button class="dropdown-item" type="button">Sort</button>
                </div>
              </div>
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="order_table">
           <thead>
            <tr>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Times been ordered</th>
                <th>Merchant Name</th>

            </tr>
           </thead>

           <tbody>
          foreach ($product as $item)

            <tr>
                <td>'name'</td>
                <td>'price'</td>
                <td>'created_at'</td>
                <td>'merchant_name'</td>
               </tr>


        </tbody>
       </table>
   </div>
  </div>
 </body>
</html>

{{-- <script>
$(document).ready(function(){
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });

 load_data();

 function load_data(from_date = '', to_date = '')
 {
  $('#products_table').DataTable({
   processing: true,
   serverSide: true,
   ajax: {
    url: "{{ route('products') }}",
    data:{from_date:from_date, to_date:to_date}
   },
   columns: [
    {
     data:'name',
     name:'name'
    },
    {
     data:'price',
     name:'price'
    },
    {
     data:'created_at',
     name:'created_at'
    },
    {
     data:'merchant_id',
     name:'merchant_id'
    }
   ]
  });
 }

 $('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date != '' &&  to_date != '')
  {
   $('#products_table').DataTable().destroy();
   load_data(from_date, to_date);
  }
  else
  {
   alert('Both Date is required');
  }
 });

 $('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  $('#order_table').DataTable().destroy();
  load_data();
 });

});
</script> --}}
---------------------------------------------------------------------------------------------------------
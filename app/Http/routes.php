<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testPost',function(){
    $csrf_token = csrf_token();
    $form = <<<FORM
        <form action="/hello" method="POST">
            <input type="hidden" name="_token" value="{$csrf_token}">
            <input type="submit" value="Test"/>
        </form>
FORM;
    return $form;
});



/*Route::any('/hello/{name}',function($name){//必须要携带参数  优先级1
    return "Hello Laravel!".$name;
});*/
Route::any('/hello/{name?}',function($name="Laravel"){//非必须要携带参数 
    return "Hello !".$name;
})->where('name','[A-Za-z]+');//限制name de输入类型只能是英文字母
	
//路由命名
Route::get('/test/do/name/{id?}',['as'=>'testdo',function($id=1){
	 return 'Hello LaravelAcademy！路由命名'.$id;
}]);

Route::get('/testNamedRoute/{id?}',function($id=1){
   return redirect()->route('testdo',['id'=>$id]);//重定向到路由命名的位置 参数携带
});
//路由分组
Route::group(['as' => 'admin::'], function () {
    Route::get('dashboard', ['as' => 'dashboard', function () {
        //
    }]);
});

Route::get('/testNamedRoute1',function(){
    return route('admin::dashboard');
});

//使用中间件控制访问
Route::group(['middleware'=>'test'],function(){
    Route::get('/write/laravelacademy',function(){
        //使用Test中间件
		return "OK!访问正常";
    });
    Route::get('/update/laravelacademy',function(){
       //使用Test中间件
		return "OK!访问正常";
    });
});

Route::get('/age/refuse',['as'=>'refuse',function(){
    return "未成年人禁止入内！middleware访问控制";
}]);
//使用路由前缀
Route::group(['prefix'=>'lar/{version}'],function(){
    Route::get('write',function($version){
        return "Write LaravelAcademy 路由前缀来控制 {$version}";
    });
    Route::get('update',function($version){
        return "Update LaravelAcademy {$version}";
    });
});

Route::get('user/{name}', 'UserController@test');
Route::get('user', 'UserController@index');

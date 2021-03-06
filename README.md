# basicrouter
<p>
This router is based on simonhamp/routes of which I forked months ago. There is nothing wrong about the original router. However, I decided to add another method to extract the controller and the controller method from the route() shown in the original class.
</p>

<h3>Installation</h3>
This can be installed using composer.
<pre><code>
{

	"require":{
	              "basicrouter": "dev-master"
				
		},
       "repositories": [
   
   {
   	"type": "vcs",
   	"url": "https://github.com/Bryan-D-Lee/basicrouter"

   }
   ]  
		
}
				

</code></pre>

<p>
If you install it via composer, make sure to add namespace on top of the Router class.
<pre><code>
&lt;?php namespace System\Libraries;

</code>
</pre>
</p>

<h3>Example of composer installed</h3>
<pre>
<code>
&lt;?php

require_once(__DIR__ .'/vendor/autoload.php');

$routes = array(
       
        'controller/(:any)/(:any)/(:any)' => 'test/index/$1/$2/$3/',
        'register/' => 'MyController/myController_action'

        );
		
$url = 'dir/controller/method/param_one/param_two/param_threee';
$default_dir = ('dir/');
$request = trim(str_replace($default_dir, '', $url));		
		
System\Libraries\Router::add($routes);
$action_request = System\Libraries\Router::route($request);

print_r(array_filter($action_request));


</pre>
</code>


<h3> Alternative installation example</h3>
<pre><code>
&lt;?php

include('Router.php');

$routes = array(
       
        'controller/(:any)/(:any)/(:any)' => 'test/index/$1/$2/$3/',
        'register/' => 'MyController/myController_action'

        );
		
$url = 'dir/controller/method/param_one/param_two/param_threee';
$default_dir = ('dir/');
$request = trim(str_replace($default_dir, '', $url));		
		
Router::add($routes);
$action_request = Router::route($request);

print_r(array_filter($action_request));

</code>
</pre>

The above examples should return something like this
<p>
   Array ( [0] => test [1] => index [2] => method [3] => param_one [4] => param_two [5] => param_threee )
 </p>  
By writing a simple dispatcher, we can easily dispatch the controller/action + parameters (coming up soon).

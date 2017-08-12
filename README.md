# Laravel Flywheel

This is a wrapper class for the Jamesmoss/flywheel package. 

## A laravel facade for flat file documents

This is a facade that can be used beside the default laravel database structure. Since this doesn't override Laravel's core database functionality you can use both at the same time.

## installation

    composer require allenjd3\laravel-flywheel
    
Then add to your config/app file under application providers

    'providers' => [
        ...
            /*
            * Package Service Providers...
            */
            Allenjd3\Flywheel\FlywheelServiceProvider::class,
        ...
    ]

If you want to use the Facade then add this to your aliases array

    'aliases' => [
        ... 
        'Flywheel' => Allenjd3\Flywheel\facades\Flywheel::class,
        ...
    
    ]

## Methods

### Config
This method is optional if you want to change either the table name or storage path

Example- (optional)

    $flywheel = Flywheel::config($name, $path);
    $flywheel->findAll();

### Create

This method creates a new Document and saves it to your path.
You can use laravel validation on the request before running this.

    $id = Flywheel::create($array)
    
### Update / findById

This method updates a post. You must find the post by id before updating it.

    $doc = Flywheel::findById($id);
    $doc->param = "new value";
    Flywheel::update($doc);

### findAll

This method finds all documents within the given configuration path

    $docs = Flywheel::findAll();

### Delete

This method deletes a post that matches a given id. 

    Flywheel::delete($id)

### Where / get

This method returns a query object that can be chained

    $docs = Flywheel::where('title', '==', 'Shiver Me Timbers')->get();
    
Get ends the queries and executes the result.

### limit, orderBy, andWhere

    $docs = Flywheel::limit($count, $offset)->get();
    $docs = Flywheel::orderBy('fieldname ASC|DESC')->get();
    
andWhere is a wrapper for additional where queries.

All types of queries, (where, limit, orderby, andWhere) can be chained before calling get.
Example-

    $docs = Flywheel::where('title','==','Most Excellent')
                    ->limit(5,2)
                    ->orderBy('title ASC')
                    ->get();


### First

If you only want to return a single document you can run first instead of get

    $doc = Flywheel::where('title', '==', 'Most Excellent')->first();

All returned values can be returned and will return a json string. 

    return $docs;

If you want to return a laravel response object with application/json headers then you can run

    return $docs->toJson();

or

    return $docs->toArray();

of course you can always pass the variable into a Blade template

    return view('template.name', compact('docs'));

### Find an error or want a feature?

Send a pull request!


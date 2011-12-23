# Favorites Plugin for CakePHP #

Favorites plugin allows to associate users to any record in your database through human readable tags or categories.

## Installation ##

1. Place the favorites folder into any of your plugin directories for your app (for example app/plugins or cake/plugins)
3. Create database tables using either the schema shell or the migrations plugin:
		cake schema create -plugin favorites -name favorites
		cake migration run all -plugin favorites
4. Attach the Favorite behavior to your models via the $actsAs variable or dynamically using the BehaviorsCollection object methods:
		public $actsAs = array('Favorites.Favorite')
	or
		$this->Behaviors->attach('Favorites.Favorite')
5. This plugin requires to have setup some parameters in global Configure storage:
	Favorites.types contains supported objects that allowed to be stored as favorites.
	Favorites.modelCategories allow to list all models and required contains for it.
	Favorites.defaultTexts sets the default text for the helper toggleFavorite method

			Configure::write('Favorites.types', array('post' => 'Blogs.Post', 'link' => 'Link'));
			Configure::write('Favorites.modelCategories', array('Post', 'Link'));

	Or you could use the Configure::load() method for a file with the following example content:

			$config['Favorites'] = array(
				'types' => array(
					'favorite' => 'Post',
					'watch' => 'Post'),
				'defaultTexts' => array(
					'favorite' => __('Favorite it', true),
					'watch' => __('Watch it', true)),
				'modelCategories' => array(
					'Post'));

## Usage ##

1. Add the Favorites helper to you controller
		public $helpers = array('Favorites.Favorites');
2. Use the helper in your views to generate links mark a model record as favorite
		<?php echo $this->Favorites->toggleFavorite('favorite-type', $modelId); 

This link will toggle the "favorite-type" tag for this user and model record

If you want the helper to distinguish whether it needs to activate or deactivate the favorite flag in for the user,you need to pass to the view the variable "userFavorites" containing an associative array of user favorites per favorite type. This structure is needed

	array(
		'favorite-type1' => array(
			'favorite-id1' => 'model-foreignKey-1',
			'favorite-id2' => 'model-foreignKey-3'
			'favorite-id3' => 'model-foreignKey-2'
		),
		'favorite-type2' => array(
			'favorite-id4' => 'model-foreignKey-1',
			'favorite-id5' => 'model-foreignKey-3'
			'favorite-id6' => 'model-foreignKey-2'
		)
	);

You can achieve this result with a method like this one

	public function getFavorites($user = null) {
		$keys = array('favorite', 'want-it', 'own-it');
		$result = array_fill_keys($keys, array());

		if (!is_null($user)) {
			$Favorite = ClassRegistry::init('Favorites.Favorite');
			$list = $Favorite->getFavorites($user, array('type' => $keys));
			$list = Set::combine($list, '{n}.Favorite.id', '{n}.Favorite.foreign_key', '{n}.Favorite.type');

			$result = array_merge($result, $list);
		}

		return $result;
	}


## Configuration Options ##
The Favorite behavior has some configuration option to adapt to your app needs. The configuration array accepts the following keys

1. favoriteAlias: The name of the association to be created with the model the Behavior is attached to and the favoriteClass model. Default: Favorite
2. favoriteClass: If you need to extend the Favorite model or override it with your own implementation set this key to the model you want to use
3. foreignKey: the field in your table that serves as reference for the primary key of the model it is attached to. (Used for own implementations of Favorite model)
4. counter_cache: the name of the field that will hold the number of times the model record has been favorited

## Callbacks ##

Additionally the behavior provides two callbacks to implement in your model:

1. beforeSaveFavorite - called before save favorite. Should return boolean value.
2. afterSaveFavorite - called after save favorite.

## Requirements ##

* PHP version: PHP 5.2+
* CakePHP version: Cakephp 1.3 Stable

## Support ##

For support and feature request, please visit the [Favorites Plugin Support Site](http://cakedc.lighthouseapp.com/projects/59901-favourites-plugin/).

For more information about our Professional CakePHP Services please visit the [Cake Development Corporation website](http://cakedc.com).

## License ##

Copyright 2009-2010, [Cake Development Corporation](http://cakedc.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.

## Copyright ###

Copyright 2009-2010<br/>
[Cake Development Corporation](http://cakedc.com)<br/>
1785 E. Sahara Avenue, Suite 490-423<br/>
Las Vegas, Nevada 89104<br/>
http://cakedc.com<br/>
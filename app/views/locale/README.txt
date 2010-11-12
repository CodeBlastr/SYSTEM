/**
 * locale README 
 *
 * This directory is here as an example of how to have different languages for your application.  
 *
 * In order to enable languages put this line of code into /app/controllers/app_controller.php
 * Configure::write('Config.language', 'fr');
 *   
 *
 * "fr" = the directory of your customized language files.
 * 
 * 
 * A note about languages...
 *
 * We have chosen to make language files complete view files, as opposed to language only files, for the purpose that you can enable entire views to be different that way instead of just the wording.  (ie. different images and different html and style even).  
 *
 * It also has a couple of other added benefits.  #1 processing time.  #2 if you have a multi site setup, you can customize view files without having to copy the entire plugin directory when customizing plugins.  (please note, if you're editing the controller or model of a plugin however, you would still be better off copying the entire plugin directory to your /sites/domain directory. 
 *
 * These are the possible locations for language files
 * app/views/locale/[languageCode]/[controllerName]/[method].ctp
 * app/views/locale/[languageCode]/plugins/[pluginName]/[controllerName]/[method].ctp
 * app/plugins/[pluginName]/views/locale/[languageCode]/[controllerName]/[method].ctp
 * sites/[siteFolder]/views/locale/[languageCode]/[controllerName]/[method].ctp
 * sites/[siteFolder]/views/locale/[languageCode]/plugins/[pluginName]/[controllerName]/[method].ctp
 * 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.views.locale
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo 		  We have not completed a way to handle multiple languages for database driven text.
 */
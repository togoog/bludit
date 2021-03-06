<?php defined('BLUDIT') or die('Bludit CMS.');

class dbSite extends dbJSON
{
	public $dbFields = array(
		'title'=>		'I am Guybrush Threepwood, mighty developer',
		'slogan'=>		'',
		'description'=>		'',
		'footer'=>		'I wanna be a pirate!',
		'itemsPerPage'=>	6,
		'language'=>		'en',
		'locale'=>		'en, en_US, en_AU, en_CA, en_GB, en_IE, en_NZ',
		'timezone'=>		'America/Argentina/Buenos_Aires',
		'theme'=>		'pure',
		'adminTheme'=>		'default',
		'homepage'=>		'',
		'pageNotFound'=>	'',
		'uriPage'=>		'/',
		'uriTag'=>		'/tag/',
		'uriCategory'=>		'/category/',
		'uriBlog'=>		'/blog/',
		'url'=>			'',
		'emailFrom'=>		'',
		'dateFormat'=>		'F j, Y',
		'timeFormat'=>		'g:i a',
		'currentBuild'=>	0,
		'twitter'=>		'',
		'facebook'=>		'',
		'codepen'=>		'',
		'googlePlus'=>		'',
		'instagram'=>		'',
		'github'=>		'',
		'gitlab'=>		'',
		'linkedin'=>		'',
		'orderBy'=>		'date', // date or position
		'extremeFriendly'=>	true,
		'autosaveInterval'=>	2, // minutes
		'titleFormatHomepage'=>	'{{site-slogan}} | {{site-title}}',
		'titleFormatPages'=>	'{{page-title}} | {{site-title}}',
		'titleFormatCategory'=> '{{category-name}} | {{site-title}}',
		'titleFormatTag'=> 	'{{tag-name}} | {{site-title}}'
	);

	function __construct()
	{
		parent::__construct(DB_SITE);

		// Set timezone
		$this->setTimezone( $this->timezone() );

		// Set locale
		$this->setLocale( $this->locale() );
	}

	// Returns an array with site configuration.
	function get()
	{
		return $this->db;
	}

	public function set($args)
	{
		// Check values on args or set default values
		foreach ($this->dbFields as $field=>$value) {
			if (isset($args[$field])) {
				// Sanitize if will be stored on database
				$finalValue = Sanitize::html($args[$field]);
				settype($finalValue, gettype($value));
				$this->db[$field] = $finalValue;
			}
		}
		return $this->save();
	}

	// Returns an array with the URL filters
	// Also, you can get the a particular filter
	public function uriFilters($filter='')
	{
		$filters['admin'] = '/'.ADMIN_URI_FILTER;
		$filters['page'] = $this->getField('uriPage');
		$filters['tag'] = $this->getField('uriTag');
		$filters['category'] = $this->getField('uriCategory');

		if ($this->getField('uriBlog')) {
			$filters['blog'] = $this->getField('uriBlog');
		}

		if (empty($filter)) {
			return $filters;
		}

		if (isset($filters[$filter])) {
			return $filters[$filter];
		}

		return false;
	}

	// Returns the URL of the rss.xml file
	// You need to have enabled the plugin RSS
	public function rss()
	{
		return DOMAIN_BASE.'rss.xml';
	}

	// Returns the URL of the sitemap.xml file
	// You need to have enabled the plugin Sitemap
	public function sitemap()
	{
		return DOMAIN_BASE.'sitemap.xml';
	}

	public function autosaveInterval()
	{
		return $this->getField('autosaveInterval');
	}

	public function extremeFriendly()
	{
		return $this->getField('extremeFriendly');
	}

	public function twitter()
	{
		return $this->getField('twitter');
	}

	public function facebook()
	{
		return $this->getField('facebook');
	}

	public function codepen()
	{
		return $this->getField('codepen');
	}

	public function instagram()
	{
		return $this->getField('instagram');
	}

	public function github()
	{
		return $this->getField('github');
	}

	public function gitlab()
	{
		return $this->getField('gitlab');
	}

	public function googlePlus()
	{
		return $this->getField('googlePlus');
	}

	public function linkedin()
	{
		return $this->getField('linkedin');
	}

	public function orderBy()
	{
		return $this->getField('orderBy');
	}

	// Returns the site title
	public function title()
	{
		return $this->getField('title');
	}

	// Returns the site slogan
	public function slogan()
	{
		return $this->getField('slogan');
	}

	// Returns the site description
	public function description()
	{
		return $this->getField('description');
	}

	public function emailFrom()
	{
		return $this->getField('emailFrom');
	}

	public function dateFormat()
	{
		return $this->getField('dateFormat');
	}

	public function timeFormat()
	{
		return $this->getField('timeFormat');
	}

	// Returns the site theme name
	public function theme()
	{
		return $this->getField('theme');
	}

	// Returns the admin theme name
	public function adminTheme()
	{
		return $this->getField('adminTheme');
	}

	// Returns the footer text
	public function footer()
	{
		return $this->getField('footer');
	}

	public function titleFormatPages()
	{
		return $this->getField('titleFormatPages');
	}

	public function titleFormatHomepage()
	{
		return $this->getField('titleFormatHomepage');
	}

	public function titleFormatCategory()
	{
		return $this->getField('titleFormatCategory');
	}

	public function titleFormatTag()
	{
		return $this->getField('titleFormatTag');
	}

	// Returns the full domain and base url
	// For example, https://www.domain.com/bludit
	public function url()
	{
		return $this->getField('url');
	}



	// Returns the protocol and the domain, without the base url
	// For example, http://www.domain.com
	public function domain()
	{
		// If the URL field is not set, try detect the domain.
		if(Text::isEmpty( $this->url() )) {
			if(!empty($_SERVER['HTTPS'])) {
				$protocol = 'https://';
			}
			else {
				$protocol = 'http://';
			}

			$domain = trim($_SERVER['HTTP_HOST'], '/');
			return $protocol.$domain;
		}

		// Parse the domain from the field url (Settings->Advanced)
		$parse = parse_url($this->url());
		$domain = rtrim($parse['host'], '/');
		$port = !empty($parse['port']) ? ':'.$parse['port'] : '';
		$scheme = !empty($parse['scheme']) ? $parse['scheme'].'://' : 'http://';

		return $scheme.$domain.$port;
	}

	// Returns the timezone.
	public function timezone()
	{
		return $this->getField('timezone');
	}

	// Returns the current build / version of Bludit.
	public function currentBuild()
	{
		return $this->getField('currentBuild');
	}

	// Returns the amount of pages per page
	public function itemsPerPage()
	{
		return $this->getField('itemsPerPage');
	}

	// Returns the current language.
	public function language()
	{
		return $this->getField('language');
	}

	// Returns the current locale.
	public function locale()
	{
		return $this->getField('locale');
	}

	// Returns the current homepage, FALSE if not defined homepage
	public function homepage()
	{
		$homepage = $this->getField('homepage');
		if( empty($homepage) ) {
			return false;
		}
		return $homepage;
	}

	// Returns the page key for the page not found
	public function pageNotFound()
	{
		$pageNotFound = $this->getField('pageNotFound');
		return $pageNotFound;
	}

	// Set the locale, returns TRUE is success, FALSE otherwise
	public function setLocale($locale)
	{
		$localeList = explode(',', $locale);
		foreach ($localeList as $locale) {
			$locale = trim($locale);
			if (setlocale(LC_ALL, $locale.'.UTF-8')!==false) {
				return true;
			}
			elseif (setlocale(LC_ALL, $locale)!==false) {
				return true;
			}
		}

		// Not was possible to set a locale, using default locale
		return false;
	}

	// Set the timezone.
	public function setTimezone($timezone)
	{
		return date_default_timezone_set($timezone);
	}

}

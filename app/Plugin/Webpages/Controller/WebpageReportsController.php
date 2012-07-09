<?php
class WebpageReportsController extends WebpagesAppController {

	public $name = 'WebpageReports';
	public $uses = array();
	
	
	public function dashboard() {
		$chartData = $this->_monthPageViewsVisits();
		if ($chartData = $this->_monthPageViewsVisits()) {
			$this->set(compact('chartData')); 
		} else {
			$this->Session->setFlash(__('No analytics data, please check settings.', true));
		}
	}
	
	
/**
 * A temporary function to hold the first example of a chart data return.
 * We can make this more robust and to handle more uses cases.
 * @todo  	Make an entire analytics plugin to be part of the reports plugin.
 */
	public function _monthPageViewsVisits() {
		
		if(!empty($instance) && defined('__REPORTS_ANALYTICS_'.$instance)) {
			extract(unserialize(constant('__REPORTS_ANALYTICS_'.$instance)));
		} else if (defined('__REPORTS_ANALYTICS')) {
			extract(unserialize(__REPORTS_ANALYTICS));
		}
		
		if (!empty($userName) && !empty($password) && !empty($setAccount)) {			
			App::import('Vendor', 'Reports.gapi');
			
			$ga = new gapi($userName, $password, isset($_SESSION['ga_auth_token']) ? $_SESSION['ga_auth_token'] : null );
			
			$_SESSION['ga_auth_token'] = $ga->getAuthToken();
			// $filter = 'country == United States && browser == Firefox || browser == Chrome';
			// $report_id, $dimensions, $metrics, $sort_metric=null, $filter=null, $start_date=null, $end_date=null, $start_index=1, $max_results=30
			// http://code.google.com/apis/analytics/docs/gdata/gdataReferenceDimensionsMetrics.html#ga:visitors
						
			foreach ($ga->requestAccountData() as $account) {
				if (is_object($account)) {
					if ($account->properties['webPropertyId'] == $setAccount) {
						$reportId = $account->properties['profileId'];
					}
				}
			}
			
			$backMonth = date('Y-m-d', mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
			$ga->requestReportData(53475, array('date'), array('pageviews','visits'), 'date', null, $backMonth, date('Y-m-d'));
			$i = 0;
			foreach($ga->getResults() as $result) {
				#debug($result);
				$chartData[$i]['pageviews'] = $result->getPageviews();
				$chartData[$i]['visits'] = $result->getVisits();
				$chartData[$i]['date'] = $result->getDate();
				$i++;
			}
			
			$chartData['totalResults'] = $ga->getTotalResults();
			$chartData['totalPageViews'] = $ga->getPageviews();
			$chartData['totalVisits'] = $ga->getVisits();
			$chartData['updated'] = $ga->getUpdated();
			
			return $chartData;
			
		} else {
			// google analytics username and password must be set in settings (__REPORTS_ANALYTICS)
			return;
		}
	}	
	
}
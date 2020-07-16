<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Category extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->return = array('status' => false, 'message' => 'Something wrong', 'data' => []);

		// $this->load->model("api_auth_model");
		$this->load->model("api_general_settings");
		$this->load->model("api_category_model");
		$this->load->model("api_product_model");
		$this->load->model("api_file_model");
		$this->load->model("location_model");
		$this->load->helper('api_helper');
		$this->product_per_page = 15;

	}

	public function getlist_get()
	{	
		$siteLangs = $this->api_general_settings->getValueOf('site_lang');
		$sitelang = api_lang_helper($siteLangs)->id; //call from api_helper
		$categoryList = $this->api_category_model->get_parent_categories($sitelang);
		$cateList = [];
		foreach ($categoryList as $cat) {
			$catList = [
				'id' => $cat->id,
				'slug' => $cat->slug,
				'name' => $cat->name,
				'title_meta_tag' => $cat->title_meta_tag,
				'description' => $cat->description,
				'keywords' => $cat->keywords,
				'show_image_on_navigation' => $cat->show_image_on_navigation,
			];
			if ($cat->slug == 'pertanian-3') {
				$catList['image_1'] = base_url() . 'assets/img/pertanianfix.jpg';
				$catList['image_2'] = base_url() . 'assets/img/pertanian.png';
			}elseif ($cat->slug == 'perkebunan-4') {
				$catList['image_1'] = base_url() . 'assets/img/perkebunanfix.jpg';
				$catList['image_2'] = base_url() . 'assets/img/perkebunan.png';
			}elseif ($cat->slug == 'perikanan') {
				$catList['image_1'] = base_url() . 'assets/img/perikananfix.jpg';
				$catList['image_2'] = base_url() . 'assets/img/perikanan.png';
			}elseif ($cat->slug == 'peternakan') {
				$catList['image_1'] = base_url() . 'assets/img/peternakanfix.jpg';
				$catList['image_2'] = base_url() . 'assets/img/peternakan.png';
			}elseif ($cat->slug == 'ukm') {
				$catList['image_1'] = base_url() . 'assets/img/ukmfix.jpg';
				$catList['image_2'] = base_url() . 'assets/img/peternakan.png';
			}elseif ($cat->slug == 'jasa') {
				$catList['image_1'] = base_url() . 'assets/img/jasafix.jpg';
				$catList['image_2'] = '';
			}
			$cateList[] = $catList;
		}

		if ($cateList) {
			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $cateList;
		}else {
			$this->return['message'] = "No data";
		}

		$this->response($this->return);
	}

	public function getproductlist_get()
	{
		$catId = $this->get('cat_id');
		if (!$catId) {
			return $this->response($this->return);
		}
		$page = $this->get('page') ?: '1';
		$perPage = $this->get('per_page') ?: $this->product_per_page;
		$offset = $perPage * ($page - 1);

		$getData = [
			'condition' => $this->get('condition'),
			'p_min' => $this->get('p_min'),
			'p_max' => $this->get('p_max'),
			'sort' => $this->get('sort'),
			'search' => $this->get('search'),
			'country' => $this->get('country'),
			'state' => $this->get('state'),
			'city' => $this->get('city')
		];

		if (!is_numeric($getData['state']) && $getData['state']) {
            $state = $this->convertCity($getData['state']);
            $mappingState = $this->mappingState($state);
            $getData['state'] = null;
            if ($mappingState) {
                $dataState = $this->getAllStateIndo()[$mappingState[0]];
                $stateId = $dataState['id'];
                $getData['state'] = $stateId;
            }
        }

        if (!is_numeric($getData['city']) && $getData['city']) {
            $city = $this->convertCity($getData['city']);
            $mappingCity = $this->mappingCity($city);
            $getData['city'] = null;
            if ($mappingCity) {
                $dataCity = $this->getAllCityIndo()[$mappingCity[0]];
                $cityId = $dataCity['id'];
                $getData['city'] = $cityId;
            }
        }
		
		$data['total'] = $this->api_product_model->get_paginated_filtered_products_count($catId, null, null, $getData);
		$products = $this->api_product_model->get_paginated_filtered_products($catId, null, null, $perPage, $offset, $getData);
		$datas = [];
		foreach ($products as $productValue) {
			$dataProduct = listdataProduct($productValue);
			$image = $this->api_file_model->get_image_by_product($productValue->id);
			$dataProduct['image'] = generateImgProduct($image,'image_small');

			$datas[] = $dataProduct;
		}
		$data['product'] = $datas;
		
		$data['total_per_page'] = count($datas);

		if ($data['product']) {
			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $data;
		}else {
			$this->return['message'] = "No data";
		}

		$this->response($this->return);
	}

	public function getAllCityIndo()
    {
        $city = $this->location_model->get_cities_indo();
        $dataCity = [];
        foreach ($city as $cities) {
            $dataCity[] = [
                'name' => $this->convertCity($cities->name),
                'id' => $cities->id,
                'state_id' => $cities->state_id
            ];
        }
        return $dataCity;
    }

    public function getAllStateIndo()
    {
        $state = $this->location_model->get_state_indo();
        $dataState = [];
        foreach ($state as $states) {
            $dataState[] = [
                'name' => $this->convertCity($states->name),
                'id' => $states->id
            ];
        }
        return $dataState;
    }

    private function convertCity($cityName)
    {
        $city = str_replace('-', ' ', $cityName);
        $city = strtolower($city);

        return $city;
    }

    public function mappingCity($city)
    {
        $input = preg_quote($city, '~');
        $data = $this->getAllCityIndo();

        foreach ($data as $cityName) {
            $citiesName[] = $cityName['name'];
        }

        $result = preg_grep('~' . $city . '~', $citiesName);

        return array_keys($result);
    }

    public function mappingState($state)
    {
        $input = preg_quote($state, '~');
        $data = $this->getAllStateIndo();

        foreach ($data as $stateName) {
            $statesName[] = $stateName['name'];
        }

        $result = preg_grep('~' . $state . '~', $statesName);

        return array_keys($result);
    }
}
?>

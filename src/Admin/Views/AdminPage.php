<?php

namespace WpClusterCache\Admin\Views;

use WpClusterCache\Admin\Helpers\HtmlForm;
use WpClusterCache\Admin\Helpers\HtmlTab;


class AdminPage extends HtmlForm {

	protected $_html = [];

	public function __construct( $attr = [], $content = [] ) {
		if ( ! $content ) {


			$content[] = $this->page( [
				$this->title( 'Cluster Cache' ),
				$this->p( 'Wordpress Plugin that cleans cache files to other servers from a cluster.' ),
				$this->tabs()
			] );
		}
		parent::__construct( $attr, $content );

	}

	public function page( $html ) {
		return $this->wrap( $this->form( $html ), 'div', [ 'class' => 'wrap' ] );
	}

	public function tabs() {
		$tabs = [
			new HtmlTab( [ 'id' => 'general', 'title' => 'Hosts', 'label' => 'Hosts' ], ( new AdminForm() )->printSettings() ),
//			new HtmlTab( [ 'id' => 'test', 'title' => 'TEST', 'label' => 'TEST'], ( new AdminForm() )->title( 'TEST' ) ),

		];

		$ul   = array_map( function ( HtmlTab $tab ) {
			$a = ( new HtmlForm )->a( $tab->getTabName(), [ 'href' => '#' . $tab->getId() ] );

			return ( new HtmlForm )->li( $a );
		}, $tabs );
		$tabs = (string) new HtmlForm( $tabs );

		return $this->wrap( [
			$this->ul( $ul ),
			$tabs,
			$this->submit( 'Save Changes' )

		], 'div', [ 'id' => 'tabs' ] );
	}


}
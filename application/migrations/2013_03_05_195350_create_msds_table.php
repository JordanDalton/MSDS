<?php

class Create_Msds_Table {

	/**
	 * Name of the database table.
	 * 
	 * @var string
	 */
	private $name = 'msds';

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create Table
		Schema::create( $this->name , function($table){
			$table->increments('id');
			$table->boolean('active')->default(0);
			$table->integer('hmis_health')->default(0);
			$table->integer('hmis_flammability')->default(0);
			$table->integer('hmis_physical_hazard')->default(0);
			$table->integer('hmis_personal_protection')->default(0);
			$table->boolean('hmis_research_pending')->default(0);
			$table->string('manufacturer')->nullable();
			$table->string('name')->nullable();
			$table->string('pdf')->nullable();
			$table->date('pdf_date')->nullable();
			$table->string('pdf_date_manual')->length(40)->nullable();
			$table->date('pdf_date_manual')->nullable();
			$table->string('synonym')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop Table
		Schema::drop( $this->name );
	}

}
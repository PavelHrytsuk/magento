define([
	'jquery',
	'mage/url',
], function($, urlBuilder){

	$('.btn-block > button').click(function(){
		console.log('Button was click!');
		$.ajax({
			url: "http://education.loc/allcategories/Ajax/Get",
			type: "GET",
			success: function(data){
				console.log(data);
				console.log('Success ajax request!');
			}
		})
	})
})

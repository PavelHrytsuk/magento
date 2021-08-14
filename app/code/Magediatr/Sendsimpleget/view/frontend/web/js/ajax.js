define([
	'jquery',
	'mage/url',
], function($, urlBuilder){

	function outputSubCategory(subCategoryArray){
		let outputString = '';
		$.each(subCategoryArray, function(subCategoryName){
			outputString += `${subCategoryName}, `;
		})
		return outputString.slice(0, -2);
	}
	
	function sortSubCategory(mainCategoryList, data){
		$.each(mainCategoryList, function(mainCategoryIndex, mainCategory){
			mainCategory['sub_category'] = sortCategory(mainCategory['id'], data)
		})
		return mainCategoryList;
	}

	function sortCategory(parentId, data){
		let categoryArray = {}
		$.each(data, function(index, infoArray){
			$.each(infoArray, function(key, value){
				if(key == 'parent_id' && value == parentId){
					categoryArray[infoArray['name']] = infoArray
                                }
			})

		})
		return categoryArray;
	}

	$('.btn-block > button').click(function(){
		console.log('Button was click!');
		$('.inserted-data').remove()
		$('.insert-pointer').css('display', 'none');
		$.ajax({
			url: "http://education.loc/allcategories/Ajax/Get",
			type: "GET",
			success: function(data){
				let mainCategoryList = sortCategory(2, data);
				let categoriesList = sortSubCategory(mainCategoryList, data);
				$('.insert-pointer').css('display', 'block');
				$.each(categoriesList, function(categoryName, categoryInfo){
					//let categorylist = outputSubCategory()
					$('.insert-pointer').append("<tr class='inserted-data'><td>"+ categoryName +"</td><td>"+ outputSubCategory(categoryInfo['sub_category'])  +"</td</tr")
				})
			}
		})
	})
})

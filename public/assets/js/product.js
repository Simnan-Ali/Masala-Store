$(function () {

    console.log("Product JS Loaded");

    initSlug();

    initSubCategory();

    initThumbnailPreview();

    initGalleryPreview();

    initPricing();

    initCKEditor();

    initSEO();

});


function initSlug(){

    $('#name').on('input', function () {

        let slug=$(this).val()
            .toLowerCase()
            .trim()
            .replace(/\s+/g,'-')
            .replace(/[^\w\-]+/g,'');

        $('#slug').val(slug);

    });

}


function initSubCategory(){

    $('#category').change(function(){

        let id=$(this).val();

        if(id==''){

            $('#sub_category').html('<option>Select Sub Category</option>');

            return;

        }

        $.ajax({

            url: $('#category').data('url')+'/'+id,

            type:'GET',

            success:function(response){

                let html='<option value="">Select Sub Category</option>';

                $.each(response,function(i,item){

                    html+='<option value="'+item.id+'">'+item.name+'</option>';

                });

                $('#sub_category').html(html);

            }

        });

    });

}


function initThumbnailPreview(){

    $('#thumbnail').change(function(){

        let file=this.files[0];

        if(file){

            $('#thumbnailPreview')

            .attr('src',URL.createObjectURL(file))

            .show();

        }

    });

}


function initGalleryPreview(){

    $('#gallery').change(function(){

        $('#galleryPreview').html('');

        $.each(this.files,function(i,file){

            $('#galleryPreview').append(

                '<img src="'+URL.createObjectURL(file)+'" width="100" class="img-thumbnail me-2 mb-2">'

            );

        });

    });

}


function initPricing(){

    function calculatePricing(){

        let purchase = parseFloat($('#purchase_price').val()) || 0;
        let mrp = parseFloat($('#mrp').val()) || 0;
        let selling = parseFloat($('#selling_price').val()) || 0;

        let discount = 0;

        if(mrp > 0){
            discount = ((mrp - selling) / mrp) * 100;
        }

        let profit = selling - purchase;

        let margin = 0;

        if(selling > 0){
            margin = (profit / selling) * 100;
        }

        $('#discount_percent').val(discount.toFixed(2) + ' %');
        $('#profit_amount').val(profit.toFixed(2));
        $('#profit_margin').val(margin.toFixed(2) + ' %');

    }

    $('#purchase_price,#mrp,#selling_price').on('keyup change', function () {

        calculatePricing();

    });

    calculatePricing();

}


function initCKEditor(){

    if(document.querySelector('#description')){

        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {

                console.log('CKEditor Ready');

            })
            .catch(error => {

                console.error(error);

            });

    }

}


function initSEO() {

    function updateSEO() {

        let title = $('#meta_title').val().trim();
        let description = $('#meta_description').val().trim();
        let keywords = $('#meta_keywords').val().trim();

        // Character Count
        $('#titleCount').text(title.length);
        $('#descriptionCount').text(description.length);

        // Google Preview
        $('#googleTitle').text(title || 'Product Title');
        $('#googleDescription').text(description || 'Meta Description');

        // SEO Score
        let score = 0;

        // Meta Title
        if (title.length >= 30 && title.length <= 60) {
            score += 40;
        }

        // Meta Description
        if (description.length >= 80 && description.length <= 160) {
            score += 40;
        }

        // Meta Keywords
        if (keywords.length > 0) {
            score += 20;
        }

        // Progress Bar
        $('#seoScoreBar')
            .css('width', score + '%')
            .attr('aria-valuenow', score)
            .text(score + '%')
            .removeClass('bg-danger bg-warning bg-success');

        if (score < 40) {

            $('#seoScoreBar').addClass('bg-danger');

        } else if (score < 80) {

            $('#seoScoreBar').addClass('bg-warning');

        } else {

            $('#seoScoreBar').addClass('bg-success');

        }

    }

    // Product Name -> Slug + Meta Title
    $('#name').on('input', function () {

        let value = $(this).val();

        let slug = value
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w-]+/g, '');

        $('#slug').val(slug);

        $('#meta_title').val(value);

        updateSEO();

    });

    // Short Description -> Meta Description
    $('#short_description').on('input', function () {

        $('#meta_description').val($(this).val());

        updateSEO();

    });

    // Manual SEO Fields
    $('#meta_title, #meta_description, #meta_keywords').on('input keyup', function () {

        updateSEO();

    });

    updateSEO();

}







// $(document).ready(function () {

//     // ===========================
//     // Generate Slug from Name
//     // ===========================
//     $('#name').on('input', function () {

//         let value = $(this).val();

//         let slug = value
//             .toLowerCase()
//             .trim()
//             .replace(/\s+/g,'-')
//             .replace(/[^\w\-]+/g,'');

//         $('#slug').val(slug);

//     });

//     // ===========================
//     // Load Sub Categories
//     // ===========================
//     $('#category').on('change', function () {

//         let id = $(this).val();

//         if (id == '') {

//             $('#sub_category').html('<option value="">Select Sub Category</option>');
//             return;
//         }

//         $.ajax({

//             // url: "{{ url('admin/get-subcategories') }}/" + id,
//             url: $('#category').data('url') + '/' + id,
//             type: "GET",
//             dataType: "json",

//             success: function (response) {

//                 let html = '<option value="">Select Sub Category</option>';

//                 $.each(response, function (index, item) {

//                     html += '<option value="' + item.id + '">' + item.name + '</option>';

//                 });

//                 $('#sub_category').html(html);

//             },

//             error: function () {

//                 alert('Unable to load Sub Categories.');

//             }

//         });

//     });

//     // ===========================
//     // Thumbnail Preview
//     // ===========================
//     $('#thumbnail').change(function () {

//         let file = this.files[0];

//         if (file) {

//             $('#thumbnailPreview')
//                 .attr('src', URL.createObjectURL(file))
//                 .show();

//         }

//     });

//     // ===========================
//     // Gallery Preview
//     // ===========================
//     $('#gallery').change(function () {

//         $('#galleryPreview').html('');

//         $.each(this.files, function (index, file) {

//             $('#galleryPreview').append(

//                 '<img src="' + URL.createObjectURL(file) + '" class="img-thumbnail me-2 mb-2" width="100">'

//             );

//         });

//     });


//     // ===========================
//     // Calculate Discount and Profit
//     // ==========================
//     function calculatePricing(){

//         let purchase = parseFloat($('#purchase_price').val()) || 0;

//         let mrp = parseFloat($('#mrp').val()) || 0;

//         let selling = parseFloat($('#selling_price').val()) || 0;

//         // Discount %

//         let discount = 0;

//         if(mrp>0){

//             discount=((mrp-selling)/mrp)*100;

//         }

//         // Profit

//         let profit=selling-purchase;

//         // Margin %

//         let margin=0;

//         if(selling>0){

//             margin=(profit/selling)*100;

//         }

//         $('#discount_percent').val(discount.toFixed(2)+' %');

//         $('#profit_amount').val(profit.toFixed(2));

//         $('#profit_margin').val(margin.toFixed(2)+' %');

//     }
//     $('#purchase_price,#mrp,#selling_price').on('keyup change',function(){

//         calculatePricing();

//     });

//     calculatePricing();

//     // ===========================
//     // CKEditor for Description
//     // ===========================
//     ClassicEditor
//         .create(document.querySelector('#description'))
//         .then(editor=>{

//         console.log('CKEditor Ready');

//         })
//         .catch(error=>{

//         console.error(error);

//     });

//     // ===========================
//     // SEO Preview
//     // ===========================
//     function updateSEO(){

//         let title=$("#meta_title").val();

//         let description=$("#meta_description").val();

//         $("#titleCount").text(title.length);

//         $("#descriptionCount").text(description.length);

//         $("#googleTitle").text(title || "Product Title");

//         $("#googleDescription").text(description || "Meta Description");

//         let score=0;

//         if(title.length>=30 && title.length<=60)
//             score+=40;

//         if(description.length>=80 && description.length<=160)
//             score+=40;

//         if($("#meta_keywords").val().length>5)
//             score+=20;

//         $("#seoScoreBar")
//             .css('width',score+'%')
//             .text(score+'%');

//         $("#seoScoreBar")
//             .removeClass('bg-danger bg-warning bg-success');

//         if(score<40){

//             $("#seoScoreBar").addClass('bg-danger');

//         }else if(score<80){

//             $("#seoScoreBar").addClass('bg-warning');

//         }else{

//             $("#seoScoreBar").addClass('bg-success');

//         }

//     }


//     $("#name").on("input", function () {

//         $("#meta_title").val($(this).val());

//         updateSEO();

//     });

//     $("#short_description").on("input", function(){

//         $("#meta_description").val($(this).val());

//         updateSEO();

//     });

//     $("#meta_title,#meta_description,#meta_keywords").on("keyup",function(){

//         updateSEO();

//     });

//     updateSEO();


// }); // end of document ready
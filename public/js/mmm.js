
	let  toolbar = ['title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr', '|', 'indent', 'outdent', 'alignment'];
	

$(document).ready(function() {
    "use strict";
	hideInputErrors(["signup","login","forgot-password","reset-password","oauth-sp"]);
	hideElem(["#signup-loading","#signup-finish",
	          "#login-loading","#login-finish",
			  "#fp-loading","#fp-finish",
			  "#rp-loading","#rp-finish",
			  "#apt-chat-loading","#apt-chat-finish","#message-reply-loading",
                          "#as-other"
			  ]);
	
	hideElem(['#send-message-type-error','#send-message-subject-error','#send-message-msg-error', '#send-message-email-div']);
	
	hideElem(["#sps-row","#add-product-loading"]);
	
	/**
	//Init wysiwyg editors
	Simditor.locale = 'en-US';
	let aptDescriptionTextArea = $('#add-product-description');
	//console.log('area: ',aptDescriptionTextArea);
	**/
	
    
     $('#spp-show').click((e) => {
	   e.preventDefault();
	   let spps = $('#spp-s').val();
	   
	   if(spps == "hide"){
		   $('#as-password').attr('type',"password");
		   $('#spp-show').html("Show");
		   $('#spp-s').val("show");
	   }
	   else{
		   $('#as-password').attr('type',"text");
		   $('#spp-show').html("Hide");
		   $('#spp-s').val("hide");
	   }
   });
		
		$("#server").change((e) =>{
			e.preventDefault();
			let server = $("#server").val();
			console.log("server: ",server);
			
			if(server == "other"){
				$('#as-other').fadeIn();     
            }
            else{
				$('#as-other').hide();     
            }
			
		});
		 $("#add-sender-submit").click(function(e){            
		       e.preventDefault();
			   let valid = true;
			   let name = $('#as-name').val(), username = $('#as-username').val(),
			   pass = $('#as-password').val(), s = $('#server').val(),
			   ss = $('#as-server').val(), sp = $('#as-sp').val(), sec = $('#as-sec').val();
			   
			   if(name == "" || username == "" || pass == "" || s == "none"){
				   valid = false;
			   }
			   else{
				   if(s == "other"){
					   if(ss == "" || sp == "" || sec == "nonee") valid = false;
				   }
			   }
			   
			   if(valid){
				 $('#as-form'). submit();
			    //updateDeliveryFees({d1: d1, d2: d2});  
			   }
			   else{
				   Swal.fire({
			            icon: 'error',
                                    title: "Please fill all the required fields"
                                   })
			   }
             
		  });
	
	
    $("a.lno-cart").on("click", function(e) {
    	if(isMobile()){
    	  window.location = "cart";
       }
    })
    
	
	$("#l-form-btn").click(e => {
       e.preventDefault();
	  
       hideInputErrors("login");	  
      let id = $('#login-id').val(),p = $('#login-password').val();
		  
		  
	   if(id == "" || p == ""){
		  Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           });
	   }
	   else{
		 $('#l-form').submit();   
	   }
    });
	
	$("#s-form-btn").click(e => {
       e.preventDefault();
	  
       let fname = $('#signup-fname').val(), lname = $('#signup-fname').val(),
	       email = $('#signup-email').val(), p = $('#signup-password').val(),
		   p2 = $('#signup-password-2').val(), v = (fname == "" || lname == "" || email == "" || p == "" || p2 == "");
		  
	   if(v){
		  Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           });
	   }
	   else if(p != p2){
		   Swal.fire({
			 icon: 'error',
             title: "Passwords do not match"
           });
	   }
	   else{
		 $('#s-form').submit();   
	   }
    });
	
	$("#fp-submit").click(e => {
       e.preventDefault();
	  
       hideInputErrors("forgot-password");	  
      let id = $('#fp-email').val();
		  
		  
	   if(id == ""){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill in your email address."
           });
	   }
	   else{
		  hideElem("#fp-submit");
		  showElem("#fp-loading");
		  
		 fp({
			 email: id
		 });   
	   }
    });
	
	$("#rp-submit").click(e => {
       e.preventDefault();
	  
       hideInputErrors("reset-password");	  
      let id = $('#acsrf').val(), p = $('#rp-pass').val(), p2 = $('#rp-pass2').val();
		  
		  
	   if(p == "" || p2 == "" || p != p2){
		   let hh = "default";
		   if(p == "") hh = "Enter your new password.";
		   if(p2 == "" || p != p2) hh = "Passwords must match.";
		   
		    Swal.fire({
			 icon: 'error',
             title: hh
           });
	   }
	   else{
		  hideElem("#rp-submit");
		  showElem("#rp-loading");
		  
		 rp({
			 id: id,
			 pass: p
		 });   
	   }
    });
	
	$("#osp-submit").click(e => {
       e.preventDefault();
	  
       hideInputErrors("oauth-sp");	  
      let p = $('#osp-pass').val(), p2 = $('#osp-pass2').val();
		  
		  
	   if(p == "" || p2 == "" || p != p2){
		   if(p == "") showElem('#osp-pass-error');
		   if(p2 == "" || p != p2) showElem('#osp-pass2-error');
	   }
	   else{
		 $('#osp-form').submit();   
	   }
    });
	
	
	//DASHBOARD
	if ($('#revenue_by_room_category').length) {
            Morris.Donut({
                element: 'revenue_by_room_category',
                data: rbrcData,
             
                labelColor: '#2e2f39',
                   gridTextSize: '14px',
                colors: [
                     "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750",
                                "#0540f2"
                               
                ],

                formatter: function(x) { return "N" + x },
                  resize: true
            });
	}   
		
	if($('#total_revenue_month').length){
			 // ============================================================== 
    // Total Revenue
    // ============================================================== 
    Morris.Area({
        element: 'total_revenue_month',
        behaveLikeLine: true,
        data: trmData,
        xkey: 'x',
        ykeys: ['y'],
        labels: ['Total'],
        lineColors: ['#5969ff'],
        resize: true,
		 dateFormat: function(x) { 
		   let d = new Date(x).toString(), dd = d.split(" "), ret = "";
           if(dd.length > 4){
			 ret = `${dd[0]} ${dd[1]} ${dd[2]}, ${dd[3]}`;
		   }   
           return ret;		 
		 },
		 preUnits: "NGN"

    });
		}
	
	//EDIT USER
	$("#user-form-btn").click(e => {
       e.preventDefault();
	   
	   //side 1 validation
	   let fname = $('#user-fname').val(), lname = $('#user-lname').val(),email = $('#user-email').val(),
	       phone = $('#user-phone').val(), role = $('#user-role').val(),status = $('#user-status').val(),
		   side1_validation = (fname == "" || lname == "" || email == "" || phone == "" || role == "none" || status == "none");	  
	  
       
	   if(side1_validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   else{
		  $('#user-form').submit();		  
	   }
    });
	
	//ADD PERMISSIONS
	$("#ap-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let apSelected = false;
	   
	   for(let i = 0; i < apTags.length; i++){
		   apSelected = apSelected || apTags[i].selected;
	   }
	    console.log(apSelected);
	   let side1_validation = !apSelected;	  
	 
       
	   if(side1_validation){
		   Swal.fire({
			 icon: 'error',
             title: "Select a permission"
           })
	   }
	   else{
		   $('#ap-pp').val(JSON.stringify(apTags));
		  $('#ap-form').submit();		  
	   }
	   
	   
    });
	
	//ADD PLUGIN
	$("#apl-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let aplName = $('#apl-name').val(), aplValue = $('#apl-value').val(), aplStatus = $('#apl-status').val(),
	       validation = (aplName == "" || aplValue == "" || aplStatus == "none");
	   
	   
       
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else{
		  $('#apl-form').submit();		  
	   }
	   
	   
    });
	
	//ADD CATEGORY
	$("#add-category-submit").click(e => {
       e.preventDefault();
	   
	   //validation
	   let acName = $('#add-category-name').val(), acTag = $('#add-category-tag').val(), acDescription = $('#add-category-description').val(), emptyImage = false,
	       acParent = $('#add-category-parent').val(), acMetaTitle = $('#add-category-meta-title').val(), acMetaDescription = $('#add-category-meta-description').val(),
		   acMetaKeywords = $('#add-category-meta-keywords').val(), acImages = $('#add-category-image'), acSEOKeywords = $('#add-category-seo-keywords').val(),
		   validation = (acName == "" || acTag == "" || acMetaTitle == "");
	   
	   for(let i = 0; i < acImages.length; i++){
			   if(acImages[i].files.length < 1) emptyImage = true;
		   }
	   
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{
		  $('#add-category-form').submit();		  
	   }
	   
	   
    });
	
	//UPDATE CATEGORY
	$("#category-submit").click(e => {
       e.preventDefault();
	   
	    //validation
	   let acName = $('#category-name').val(), acTag = $('#category-tag').val(), acDescription = $('#category-description').val(), emptyImage = false,
	       acParent = $('category-parent').val(), acMetaTitle = $('category-meta-title').val(), acMetaDescription = $('category-meta-description').val(),
		   acMetaKeywords = $('category-meta-keywords').val(), acImages = $('#category-image'), acSEOKeywords = $('category-seo-keywords').val(),
		   validation = (acName == "" || acTag == "" || acMetaTitle == "");
	   
	   for(let i = 0; i < acImages.length; i++){
			   if(acImages[i].files.length < 1) emptyImage = true;
		   }
	   
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else{
		  $('#category-form').submit();		  
	   }
	   
	   
    });
	
	//ADD MANUFACTURER
	$("#add-manufacturer-submit").click(e => {
       e.preventDefault();
	   
	   //validation
	   let amName = $('#add-manufacturer-name').val(), amImages = $(`#add-manufacturer-image`), emptyImage = false,
		   validation = (amName == "");
			
	     for(let i = 0; i < amImages.length; i++){
			   if(amImages[i].files.length < 1) emptyImage = true;
		   }
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{	 
		 $('#add-manufacturer-form').submit();
	   }
	   
	   
    });
	
	
	//UPDATE MANUFACTURER
	$("#manufacturer-submit").click(e => {
       e.preventDefault();
	   
	   //validation
	   let mName = $('#manufacturer-name').val(), validation = (mName == "");
	   
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else{
		  $('#manufacturer-form').submit();		  
	   }
	   
	   
    });
	
	//ADD INFORMATION
	$("#add-information-submit").click(e => {
       e.preventDefault();
	   
	   //validation
	   let aiTitle = $('#add-information-title').val(), aiType = $('#add-information-type').val(), aiContent = $('#add-information-content').val(),
   	       validation = (aiTitle == "" || aiType == "none" || aiContent == "");
			
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{	 
		 $('#add-information-form').submit();
	   }
	   
	   
    });
	
	
	//UPDATE INFORMATION
	$("#information-submit").click(e => {
       e.preventDefault();
	   
	   //validation
	  let aiTitle = $('#add-information-title').val(), aiType = $('#add-information-type').val(), aiContent = $('#add-information-content').val(),
   	       validation = (aiTitle == "" || aiType == "none" || aiContent == "");
			
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{	 
		 $('#information-form').submit();
	   }
	   
	   
    });
	
	//ADD BANNER
	$("#ab-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let abType = $('#ab-type').val(), validation = (abType == "none"),
	        abImages = $(`#ab-images input[type=file]`), emptyImage = false;
			
	     for(let i = 0; i < abImages.length; i++){
			   if(abImages[i].files.length < 1) emptyImage = true;
		   }
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else if(emptyImage){
		   Swal.fire({
			 icon: 'error',
             title: "You have an empty image field."
           })
	   }
	   else{	 
		 $('#ab-form').submit();
	   }
	   
	   
    });
    
    //ADD FAQ
	$("#faq-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let tag = $('#faq-tag').val(), question = $('#faq-question').val(), 
       answer = $('#faq-answer').val(), validation = (question == "" || answer == "" || tag == "none");
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{	 
		 $('#faq-form').submit();
	   }   
    });
    
    $("#faq-tag-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let tag = $('#faq-tag').val(), name = $('#faq-name').val(), 
       validation = (name == "" || tag == "");
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{	 
		 $('#faq-tag-form').submit();
	   }   
    });
	
	$("#abp-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let title = $('#ap-title').val(), url = $('#ap-url').val(), description = $('#ap-description').val(), 
	     apImages = $(`#ap-images input[type=file]`), emptyImage = false, validation = (title == "" || url == "" || description == "");
			
	     for(let i = 0; i < apImages.length; i++){
			   if(apImages[i].files.length < 1) emptyImage = true;
		   }
       
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else if(emptyImage){
		   Swal.fire({
			 icon: 'error',
             title: "Please upload an image."
           })
	   }
	   
	   else{	 
		 $('#abp-form').submit();
	   }   
    });
	
	$("#ubp-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let title = $('#ap-title').val(), url = $('#ap-url').val(), description = $('#ap-description').val(), 
	     apImages = $(`#ap-images input[type=file]`), emptyImage = false, validation = (title == "" || url == "" || description == "");
			
	     for(let i = 0; i < apImages.length; i++){
			   if(apImages[i].files.length < 1) emptyImage = true;
		   }
       
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	 
	   
	   else{	 
		 $('#ubp-form').submit();
	   }   
    });
	

	
	//ADD PRODUCT
	$("#add-product-submit").click(e => {
       e.preventDefault();
	   console.log("add product submit");
	   
	   //side 1 validation
	   let apName = $('#add-product-name').val(), apMetaTitle = $('#add-product-meta-title').val(), apPrice = $('#add-product-price').val(),
	   apMetaDescription = $('#add-product-meta-description').val(),apMetaKeywords = $('#add-product-meta-keywords').val(),apDescription = $('#add-product-description').val(),
	       apCategory = $('#add-product-category').val(), apModel = $('#add-product-model').val(),apSKU = $('#add-product-sku').val(),
	       apUPC = $('#add-product-upc').val(), apEAN = $('#add-product-ean').val(), apJAN = $('#add-product-jan').val(),
		   apISBN = $('#add-product-isbn').val(), apMPN = $('#add-product-mpn').val(), apLocation = $('#add-product-location').val(),
		   apTaxClass = $('#add-product-tax-class').val(), apQty = $('#add-product-qty').val(), apMinQty = $('#add-product-min-qty').val(),
		   apShipping = $('#add-product-shipping').val(), apDateAvailable = $('#add-product-date-available').val(),
		   apWidth = $('#add-product-width').val(), apHeight = $('#add-product-height').val(), apLength = $('#add-product-length').val(),
		   apStatus = $('#add-product-status').val(), apManufacturer = $('#add-product-manufacturer').val(), apSEO = $('#add-seo-keywords').val(),
		   
		   validation = (apName == "" || apMetaTitle == "" || apModel == "" || apManufacturer == "none" || apCategory == "none"),
		   apImages = $(`#add-product-images input[type=file]`), emptyImage = false;
		   
		   for(let i = 0; i < apImages.length; i++){
			   if(apImages[i].files.length < 1) emptyImage = true;
		   }
		  
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   else if(emptyImage == false && apCover == "none"){
		   Swal.fire({
			 icon: 'error',
             title: "Select a cover image."
           })
	   }
	   else{
	
		 let fd =  new FormData();
		 fd.append("name",apName);
		 fd.append("price",apPrice);
		 fd.append("description",apDescription);
		 fd.append("meta_title",apMetaTitle);
		 fd.append("meta_description",apMetaDescription);
		 fd.append("meta_keywords",apMetaKeywords);
		 fd.append("model",apModel);
		 fd.append("sku",apSKU);
		 fd.append("upc",apUPC);
		 fd.append("ean",apEAN);
		 fd.append("jan",apJAN);
		 fd.append("isbn",apISBN);
		 fd.append("mpn",apMPN);
		 fd.append("location",apLocation);
		 fd.append("tax_class",apTaxClass);
		 fd.append("qty",apQty);
		 fd.append("min_qty",apMinQty);
		 fd.append("shipping",apShipping);
		 fd.append("date_available",apDateAvailable);
		 fd.append("length",apLength);
		 fd.append("width",apWidth);
		 fd.append("height",apHeight);
		 fd.append("status",apStatus);
		 fd.append("category",apCategory);
		 fd.append("manufacturer",apManufacturer);
		 fd.append("seo_keywords",apSEO);
		
		 fd.append("cover",apCover);
		 fd.append("img_count",apImages.length);
		 
		 for(let r = 0; r < apImages.length; r++)
		 {
		    let imgg = apImages[r];
			let imgName = `ap-image-${r}`;
            //console.log("imgg name: ",imgName);			
            fd.append(imgName,imgg.files[0]);   			   			
		 }
		 
		 /**
		 for(let vv of fd.values()){
			 console.log("vv: ",vv);
		 }
		 **/
		  fd.append("_token",tkAddProduct);
		  
		  $('#ap-submit').hide();
		  $('#ap-loading').fadeIn();
		  addProduct(fd);  
		  
	   }
    });
	
	//EDIT PRODUCT
	$("#product-submit").click(e => {
       e.preventDefault();
	   console.log("product submit");
	   
	   //side 1 validation
	   let apXF = $('#product-xf').val(), apName = $('#product-name').val(), apMetaTitle = $('#product-meta-title').val(), apPrice = $('#product-price').val(),
	   apMetaDescription = $('#product-meta-description').val(),apMetaKeywords = $('#product-meta-keywords').val(),apDescription = $('#product-description').val(),
	       apCategory = $('#product-category').val(), apModel = $('#product-model').val(),apSKU = $('#product-sku').val(),
	       apUPC = $('#product-upc').val(), apEAN = $('#product-ean').val(), apJAN = $('#product-jan').val(),
		   apISBN = $('#product-isbn').val(), apMPN = $('#product-mpn').val(), apLocation = $('#product-location').val(),
		   apTaxClass = $('#product-tax-class').val(), apQty = $('#product-qty').val(), apMinQty = $('#product-min-qty').val(),
		   apShipping = $('#product-shipping').val(), apDateAvailable = $('#product-date-available').val(),
		   apWidth = $('#product-width').val(), apHeight = $('#product-height').val(), apLength = $('#product-length').val(),
		   apStatus = $('#product-status').val(), apManufacturer = $('#product-manufacturer').val(), apSEO = $('#add-seo-keywords').val(),
		   
		   validation = (apXF == "" || apName == "" || apMetaTitle == "" || apModel == "" || apManufacturer == "none" || apCategory == "none"),
		   apImages = $(`#product-images input[type=file]`), emptyImage = false;
		   
		   for(let i = 0; i < apImages.length; i++){
			   if(apImages[i].files.length < 1) emptyImage = true;
		   }
		  
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   
	   else{
	
		 let fd =  new FormData();
		 fd.append("xf",apXF);
		 fd.append("name",apName);
		 fd.append("price",apPrice);
		 fd.append("description",apDescription);
		 fd.append("meta_title",apMetaTitle);
		 fd.append("meta_description",apMetaDescription);
		 fd.append("meta_keywords",apMetaKeywords);
		 fd.append("model",apModel);
		 fd.append("sku",apSKU);
		 fd.append("upc",apUPC);
		 fd.append("ean",apEAN);
		 fd.append("jan",apJAN);
		 fd.append("isbn",apISBN);
		 fd.append("mpn",apMPN);
		 fd.append("location",apLocation);
		 fd.append("tax_class",apTaxClass);
		 fd.append("qty",apQty);
		 fd.append("min_qty",apMinQty);
		 fd.append("shipping",apShipping);
		 fd.append("date_available",apDateAvailable);
		 fd.append("length",apLength);
		 fd.append("width",apWidth);
		 fd.append("height",apHeight);
		 fd.append("status",apStatus);
		 fd.append("category",apCategory);
		 fd.append("manufacturer",apManufacturer);
		 fd.append("seo_keywords",apSEO);
		
		 fd.append("cover",apCover);
		 fd.append("img_count",apImages.length);
		 
		 for(let r = 0; r < apImages.length; r++)
		 {
		    let imgg = apImages[r];
			let imgName = `ap-image-${r}`;
            //console.log("imgg name: ",imgName);			
            fd.append(imgName,imgg.files[0]);   			   			
		 }
		 
		 /**
		 for(let vv of fd.values()){
			 console.log("vv: ",vv);
		 }
		 **/
		  fd.append("_token",tkProduct);
		  
		  $('#ap-submit').hide();
		  $('#ap-loading').fadeIn();
		  updateProduct(fd);  
		  
	   }
    });
	
	//ORDERS
	$('#add-order-product-list').change(e =>{
		e.preventDefault();
		xf = $(this).attr('data-xf');
		
	});
	
	
	$("#add-order-product-submit").click(e => {
       e.preventDefault();
	   let p = $('#add-order-product').val(), q = $('#add-order-qty').val(), validation = (p == "" || q == "" || (typeof q === 'undefined') || parseInt(q) < 1);
	   
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   else{
		   let xe = orderProducts.find(item => item.p == p);
		   
		   if(typeof(xe) === "undefined"){
		    orderProducts.push({p: p,q: q});
		   }
		   else{
			   for(let o = 0; o < orderProducts.length; o++){ 
			      if(orderProducts[o].p == xe.p) orderProducts[o].q = q;
			   }
		   }
		   refreshProducts({type: "normal", target: "#add-order-products", t: 'add-order'});
		   refreshProducts({type: "review", target: "#add-order-products-review", t: 'add-order'});
		   
		   $('#add-order-product').val("");
		   $('#add-order-qty').val(""); 
	   }
	});
	
	$("#add-order-submit").click(e => {
       e.preventDefault();
	   
	   //side 1 validation
	   let aoCustomer = $('#add-order-customer').val(), aoTotal = $('#add-order-total').html(), aoPaymentFname = $('#add-order-payment-fname').val(), aoPaymentLname = $('#add-order-payment-lname').val(),
	       aoPaymentCompany = $('#add-order-payment-company').val(), aoPaymentAddress1 = $('#add-order-payment-address-1').val(),aoPaymentAddress2 = $('#add-order-payment-address-2').val(),
	       aoPaymentCity = $('#add-order-payment-city').val(), aoPaymentRegion = $('#add-order-payment-region').val(), aoPaymentPostcode = $('#add-order-payment-postcode').val(),
		   aoPaymentCountry = $('#add-order-payment-country').val(), side1Validation = (aoCustomer == "none" || aoPaymentFname == "" || aoPaymentLname == "" || aoPaymentAddress1 == "" || aoPaymentCity == "" || aoPaymentRegion == "" || aoPaymentCountry == "none"),
		   
		   aoShippingFname = $('#add-order-shipping-fname').val(), aoShippingLname = $('#add-order-shipping-lname').val(),
	       aoShippingCompany = $('#add-order-shipping-company').val(), aoShippingAddress1 = $('#add-order-shipping-address-1').val(),aoShippingAddress2 = $('#add-order-shipping-address-2').val(),
	       aoShippingCity = $('#add-order-shipping-city').val(), aoShippingRegion = $('#add-order-shipping-region').val(), 
		   aoShippingPostcode = $('#add-order-shipping-postcode').val(), aoShippingCountry = $('#add-order-shipping-country').val(),
		   side2Validation = (aoShippingFname == "" || aoShippingLname == "" || aoShippingAddress1 == "" || aoShippingCity == "" || aoShippingRegion == "" || aoShippingCountry == "none"),
		   
		   aoPaymentType = $('#add-order-payment-type').val(), aoShippingType = $('#add-order-shipping-type').val(), aoComment = $('#add-order-comment').val(), aoStatus = $('#add-order-status').val(),
		   side3Validation = (aoPaymentType == "none" || aoShippingType == "none" || aoStatus == "none"); 
		  
	   if(side1Validation || side2Validation || side3Validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   else if(orderProducts.length < 1){
		   Swal.fire({
			 icon: 'error',
             title: "Please add a product."
           })
	   }
	   
	   else{
	      
		 let fd =  new FormData(), payload = {
		 customer: aoCustomer,
		 amount: aoTotal,
		 payment_xf: aoPaymentXF,
		 payment_fname: aoPaymentFname,
		 payment_lname: aoPaymentLname,
		 payment_company: aoPaymentCompany,
		 payment_address_1: aoPaymentAddress1,
		 payment_address_2: aoPaymentAddress2,
		 payment_city: aoPaymentCity,
		 payment_region: aoPaymentRegion,
		 payment_postcode: aoPaymentPostcode,
		 payment_country: aoPaymentCountry,
		 shipping_xf: aoShippingXF,
		 shipping_fname: aoShippingFname,
		 shipping_lname: aoShippingLname,
		 shipping_company: aoShippingCompany,
		 shipping_address_1: aoShippingAddress1,
		 shipping_address_2: aoShippingAddress2,
		 shipping_city: aoShippingCity,
		 shipping_region: aoShippingRegion,
		 shipping_postcode: aoShippingPostcode,
		 shipping_country: aoShippingCountry,
		 payment_type: aoPaymentType,
		 shipping_type: aoShippingType,
		 comment: aoComment,
		 status: aoStatus,
		 products: JSON.stringify(orderProducts),
		 _token: tkAddOrder
		 };
		 
		 console.log("payload: ",payload);
		  
		  for(let i in payload){
			  fd.append(i,payload[i]);
		  }
		  
		  $('#ao-submit').hide();
		  $('#ao-loading').fadeIn();
		  addOrder(fd);  
		  
	   }
    });
	
	//EDIT ORDER
	$('#order-product-list').change(e =>{
		e.preventDefault();
		xf = $(this).attr('data-xf');
		
	});
	
	
	$("#order-product-submit").click(e => {
       e.preventDefault();
	   let p = $('#order-product').val(), q = $('#order-qty').val(), validation = (p == "" || q == "" || (typeof q === 'undefined') || parseInt(q) < 1);
	   
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   else{
		   let xe = orderProducts.find(item => item.p == p);
		   
		   if(typeof(xe) === "undefined"){
		    orderProducts.push({p: p,q: q});
		   }
		   else{
			   for(let o = 0; o < orderProducts.length; o++){ 
			      if(orderProducts[o].p == xe.p) orderProducts[o].q = q;
			   }
		   }
		   refreshProducts({type: "normal", target: "#order-products", t: 'order'});
		   refreshProducts({type: "review", target: "#order-products-review", t: 'order'});
		   
		   $('#order-product').val("");
		   $('#order-qty').val(""); 
	   }
	});
	
	$("#order-submit").click(e => {
       e.preventDefault();
	   
	   //side 1 validation
	   let aoCustomer = $('#order-customer').val(), aoTotal = $('#order-total').html(), aoPaymentFname = $('#order-payment-fname').val(), aoPaymentLname = $('#order-payment-lname').val(),
	       aoPaymentCompany = $('#order-payment-company').val(), aoPaymentAddress1 = $('#order-payment-address-1').val(),aoPaymentAddress2 = $('#order-payment-address-2').val(),
	       aoPaymentCity = $('#order-payment-city').val(), aoPaymentRegion = $('#order-payment-region').val(), aoPaymentPostcode = $('#order-payment-postcode').val(),
		   aoPaymentCountry = $('#order-payment-country').val(), side1Validation = (aoCustomer == "none" || aoPaymentFname == "" || aoPaymentLname == "" || aoPaymentAddress1 == "" || aoPaymentCity == "" || aoPaymentRegion == "" || aoPaymentCountry == "none"),
		   
		   aoShippingFname = $('#order-shipping-fname').val(), aoShippingLname = $('#order-shipping-lname').val(),
	       aoShippingCompany = $('#order-shipping-company').val(), aoShippingAddress1 = $('#order-shipping-address-1').val(),aoShippingAddress2 = $('#order-shipping-address-2').val(),
	       aoShippingCity = $('#order-shipping-city').val(), aoShippingRegion = $('#order-shipping-region').val(), 
		   aoShippingPostcode = $('#order-shipping-postcode').val(), aoShippingCountry = $('#order-shipping-country').val(),
		   side2Validation = (aoShippingFname == "" || aoShippingLname == "" || aoShippingAddress1 == "" || aoShippingCity == "" || aoShippingRegion == "" || aoShippingCountry == "none"),
		   
		   aoPaymentType = $('#order-payment-type').val(), aoShippingType = $('#order-shipping-type').val(), aoComment = $('#order-comment').val(), aoStatus = $('#order-status').val(),
		   side3Validation = (aoPaymentType == "none" || aoShippingType == "none" || aoStatus == "none"); 
		  
	   if(side1Validation || side2Validation || side3Validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   else if(orderProducts.length < 1){
		   Swal.fire({
			 icon: 'error',
             title: "Please add a product."
           })
	   }
	   
	   else{
	      
		 let fd =  new FormData(), payload = {
		 xf: xf,
		 customer: aoCustomer,
		 amount: aoTotal,
		 payment_xf: eoPaymentXF,
		 payment_fname: aoPaymentFname,
		 payment_lname: aoPaymentLname,
		 payment_company: aoPaymentCompany,
		 payment_address_1: aoPaymentAddress1,
		 payment_address_2: aoPaymentAddress2,
		 payment_city: aoPaymentCity,
		 payment_region: aoPaymentRegion,
		 payment_postcode: aoPaymentPostcode,
		 payment_country: aoPaymentCountry,
		 shipping_xf: eoShippingXF,
		 shipping_fname: aoShippingFname,
		 shipping_lname: aoShippingLname,
		 shipping_company: aoShippingCompany,
		 shipping_address_1: aoShippingAddress1,
		 shipping_address_2: aoShippingAddress2,
		 shipping_city: aoShippingCity,
		 shipping_region: aoShippingRegion,
		 shipping_postcode: aoShippingPostcode,
		 shipping_country: aoShippingCountry,
		 payment_type: aoPaymentType,
		 shipping_type: aoShippingType,
		 comment: aoComment,
		 status: aoStatus,
		 products: JSON.stringify(orderProducts),
		 _token: tkOrder
		 };
		 
		 console.log("payload: ",payload);
		  
		  for(let i in payload){
			  fd.append(i,payload[i]);
		  }
		  
		  $('#eo-submit').hide();
		  $('#eo-loading').fadeIn();
		  updateOrder(fd);  
		  
	   }
    });
	
	$("#order-history-submit").click(e => {
       e.preventDefault();
	   
	   //side 1 validation
	   let aohXF = $('#order-history-xf').val(), aohNC = $('#order-history-notify-customer').val(),
	       aohComment = $('#order-history-comment').val(), aohStatus = $('#order-history-status').val(),
		   validation = (aohXF == "" || aohNC == "none" || aohStatus == "none"); 
		  
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   
	   else{
	     $('#order-history-form').submit();  
	   }
    });
	
	
});

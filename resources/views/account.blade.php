@extends('layouts.app')
  
@section('content')
  <livewire:account />  
@endsection
@section('css')
  <link href="{{ asset('/assets/css/dropzoneHeader.css') }}" type="text/css" rel="stylesheet" />
  <link href="{{ asset('/assets/css/dropzoneCustome.css') }}" type="text/css" rel="stylesheet" />
  <link href="{{ asset('/assets/css/dropzone.css') }}" type="text/css" rel="stylesheet" />
  <link href="{{ asset('/assets/css/popover/jquery-popover-0.0.3.css') }}" type="text/css" rel="stylesheet" />
  <style type="text/css">
    .dropzone-section {
      width: 98%;
      border: 1px dashed #4885FF;
      background-color: #F6F9FF;
    }
    @media screen and (min-width:450px) {
        .dropzone-section {
          width: 450px;
        }
    }
    .form-input.myAttachment .fileSizeTxt {
        order: 5;
    }
    .form-input.myAttachment p.showBrowseButton {
        order: 6;
        width: 100%;
    }
    .dropzone {
      width: 100%;
      height: 75px;
      z-index: 1;
      position: relative;
      box-sizing: border-box;
      display: table;
      table-layout: fixed;
      border: 1px dashed var(--theme-border2);
      border-radius: 3px;
      text-align: center;
      overflow: hidden;
      padding: 15px 20px;
      background-color: inherit;
    }
    .dropzone.is-dragover {}
    .dropzone .content {
      display: table-cell;
      vertical-align: middle;
    }
    .dropzone .upload {
        width: 100%;
        margin: 6px 0 0 2px;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        color: var(--theme-blueviolet);
        font-size: 14px;
        line-height: 18px;
        letter-spacing: 0.5px;
        font-family: 'Lato-Bold';
    }
    .dropzone .upload svg {
        margin-right: 6px;
    }
    .dropzone .upload span {
        width: 100%;
        text-align: center;
        /*color: var(--theme-gray);*/
        font-size: 12px;
        line-height: 16px;
        letter-spacing: 0.5px;
        font-family: 'Lato-Regular';
    }
    .dropzone .filename {
      display: block;
      color: var(--theme-gray);
      font-size: 14px;
      line-height: 18px;
    }
    .dropzone .input {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      opacity: 0;
      cursor: pointer;
    }
    .fileSizeTxt {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        align-items: center;
        color: var(--theme-gray);
        gap: 6px;
        margin: 5px 0 0;
    }

    .dropzone .dz-preview.dz-image-preview {
        background: unset !important;
    }

    .dropzone .dz-preview {
        min-height: 20px !important;
    }

    .dropzone .dz-preview .dz-image{
        height: unset !important;
    }
    .dropzone {
        transition: all .4s ease-in-out;
        min-height: unset !important;
    }
    .dropzone:hover {
        /*        border-color: #7F56D9;*/
        /* background: rgb(255 255 255);*/
    }
    .dropzone .dz-message {
        margin: 0;
    }
    .dropzone .dz-preview {
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin: 10px !important;
    }
    .dropzone .dz-preview div:empty {
        display: none;
    }
    .dropzone {
        overflow: unset;
    }
    .dropzone .dz-preview .dz-error-message {
        top: 30px;
        left: 0;
        right: unset;
        margin: auto;
    }
    .dropzone .dz-preview.dz-error .dz-error-message {
        display: block;
        opacity: 1;
    }
    .dropzone .dz-preview .dz-success-mark {
        display: none;
    }
    .dropzone .dz-preview .dz-error-mark {
        display: none;
    }
    .dropzone .dz-preview .dz-success-mark svg g {
        fill: var(--theme-celadonGreen);
    }
    .dropzone .dz-preview .dz-error-mark svg g {
        fill: #be2626;
    }
    .dropzone .dz-preview span {
        max-width: 80%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .form-input p.showBrowseButton {
        width: fit-content;
        display: flex;
        align-items: center;
        gap: 20px;
        margin: 5px 0 0;
    }
    .form-input p.showBrowseButton a {
        color: #ffffff;
    }
    .form-input p.showBrowseButton ~ .fileSizeTxt {
        width: fit-content;
        margin-left: auto;
        font-size: 12px;
        line-height: 16px;
        letter-spacing: 0.5px;
        font-family: 'Lato-Regular';
        color: var(--theme-gray);
    }
    .dropzone .dz-preview {
        align-items: center;
        position: relative;
        row-gap: 2px;
    }
    .dropzone .dz-preview.dz-error, .dropzone .dz-preview.dz-error span {
        color: var(--theme-red);
    }
    .dropzone .dz-preview .dz-error-message {
        background: transparent;
        position: unset;
        color: var(--theme-red);
        padding: 0;
        margin: 0;
        text-align: left;
        width: 100%;
    }
    .dropzone .dz-preview .dz-error-message:after {
        border-color: transparent;
        display: none;
    }
    .dropzone .dz-preview .dz-remove {
        position: absolute;
        right: 0;
        top: 0;
        z-index: 9;
    }
    .dz-error-mark {
        display: none;
    }
    .dz-error-mark {
        display: none !important;
    }
    .form-input.myAttachment p.addpercentage {
        order: 4;
        width: fit-content;
    }
    .form-input.myAttachment .fileSizeTxt {
        order: 5;
    }
    .form-input.myAttachment p.showBrowseButton {
        order: 6;
        width: auto
    }
    .form-input.myAttachment .info-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-flow: row-reverse wrap;
    }
    .dz-progress {
        display: none;
    }
    .marketPlaceApplication .custom-select-wrapper .custom-select-option .custom-options{
        max-height: 200px;
        overflow: auto;
    }
    .developer-skills .close-skill svg {
        width: 13px;
        height: 13px;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
    }
    .courses.edit-skills li.btn {
        color: rgb(7, 90, 255) !important;
        font-weight: bold;
        cursor: pointer;
    }
    .popover-wrapper .popover-modal {
        top: 100%;
        left: 0;
    }
    .popover-modal .popover-body {
        overflow-x: hidden;
        overflow-y: auto;
        word-wrap: break-word;
        word-break: break-word;
        margin: 8px;
    }
    .skill_exp {
        height: 34px !important;
    }
    .btn-border:hover {
        border: 1px solid #b4c0e0 !important;
        background: #fff !important;
        color: #4f5e64 !important;
    }
    .close-education-skill, .close-soft-skill {
        position: absolute;
        right: 10px;
        top: 7px;
    }
    .close-education-skill svg, .close-soft-skill svg { 
        width: 18px;
        height: 18px;
    }
    @media screen and (min-width:768px) {
        .edit-icon {
            opacity: 0;
            transition: all .4s ease-in-out;
        }
        .profile-information .border-box-main:hover .edit-icon, .title-display-section:hover .edit-icon, .job-detail-overview:hover .edit-icon, .developer-description:hover .edit-icon, .edit-developer-skill:hover .edit-icon, .education-skills-section:hover .edit-icon, .soft-skills-section:hover .edit-icon {
            opacity: 1;
        }
    }
    @media screen and (max-width:390px) {
        .profile-main-info .profile-information .d-flex.gap-4 {
            gap: 0.5rem!important;
        }
    }
  </style>
@endsection
@section('js')
  
 
  <script data-navigate-once>
        var deleteSkills = [];
    var editSkills = [];
    var addNewSkills = [];
    var categories = [];
    var myDropzone;
    Livewire.on('categories', (data) => {
        // console.log("categories ", );
        categories = data[0];
    });
    Dropzone.autoDiscover = false;
    $(document).on('ready livewire:navigated', function() {
        
        var inputElement = document.getElementById('dev_experience');
        if(inputElement != null) {
          console.log(inputElement);
          inputElement.addEventListener('keypress', function(event) {
              // Get the entered character and form the new value
              var char = String.fromCharCode(event.which);
              var newValue = parseInt(inputElement.value + char);
              if ((newValue < 0 || newValue > 20) || Number.isNaN(newValue)) {
                  showToastMessage('Error' ,'Please enter experience between 0 and 20.');
                  event.preventDefault(); // Prevent the character from being entered
              }
          });
        }
        var inputElements = document.querySelectorAll('.skill_exp');
        inputElements.forEach(function (inputElement) {
          inputElement.addEventListener('keypress', function (event) {
            var char = String.fromCharCode(event.which);
            var newValue = parseInt(inputElement.value + char);
            if ((newValue < 0 || newValue > 20) || Number.isNaN(newValue)) {
                showToastMessage('Error' ,'Please enter experience between 0 and 20.');
                event.preventDefault(); 
            }
          });
        });
        // $('[data-role="popover"]').popover();
    });
     var loadFile = function (event) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
      };
    function autoExpand(textarea) {
        // Reset textarea height to auto to allow it to shrink
        textarea.style.height = 'auto';

        // Set the computed height of the textarea
        textarea.style.height = (textarea.scrollHeight + 2) + 'px';
    }
    function changeJobsCity(e) {

    }
    function cancelAddNewSkill(e) {
        var listItem = e.closest('div.popover-wrapper');
        if (listItem) {
            listItem.classList.remove("open");
        }
    }
    function saveAddNewSkill(e) {
        var listItem = e.closest('div.popover-wrapper');
        if (listItem) {
            var skillName = $("#devSkillDrop", listItem).val();
            var exp =  $("input[name='skill_exp']", listItem).val() ;

            if(exp == '' || skillName == '') {
                showToastMessage('Error', 'Please select skill and years of experience.');
            } else {
                listItem.classList.remove("open");
                if($(".developer-skills .courses li[data-skill='"+skillName+"'").length == 0) {
                    var categoryId = $("#devSkillDrop", listItem).find('option:selected').data('category');
                    var icon = $("#devSkillDrop", listItem).find('option:selected').data('icon');
                    if(categoryId == undefined) {
                        categoryId = 12;
                    }
                    if(icon == undefined) {
                        icon = '';
                    }
                    addNewSkills.push({ 'skill_name': skillName, 'category_id': categoryId, 'years_exp': exp }); 
                    if($('div#category-'+categoryId+' .courses').length > 0) {
                        $('div#category-'+categoryId+' .courses').append('<li class="btn btn-grey-small popover-wrapper" data-skill="'+skillName+'" data-year="'+exp+'" ><span class="d-flex justify-content-center align-items-center" onclick="editSkill(this)">'+((icon != '')?'<img src="'+icon+'" alt="'+skillName+'">':'')+' '+skillName+' ꞏ '+exp+'y </span><div class="popover-modal example-popover"><div class="popover-body"><div class="form-group"><label class="mb-5 text-start w-100">Years of experience:</label><input type="number" min="0" max="20" name="skill_exp" value="'+exp+'" class="form-control skill_exp"></div><div class="form-group d-flex"><button class="btn btn-border rounded-0 pl-10 pr-10 mr-10" type="button" name="cancel" onclick="cancelSkillUpdate(this)">Cancel</button><button class="btn btn-brand-1 rounded-0 pl-10 pr-10" type="button" name="save" onclick="saveSkillUpdate(this)">Save</button></div></div></div><span class="close-skill ml-5" onclick="deleteSkill(this)"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path fill="#231815" fill-rule="nonzero" d="M20.4 4.6l-1-1L12 11 4.6 3.6l-1 1L11 12l-7.4 7.4 1 1L12 13l7.4 7.4 1-1L13 12z"></path></g></svg></span></li>')
                    } else {
                        $('.developer-skills').append('<div class="developer-category mb-3" id="category-'+categoryId+'" wire:key="category-'+categoryId+'"><label>'+categories[categoryId]+'</label><ul class="courses edit-skills" wire:key="skillsList-'+categoryId+'"><li class="btn btn-grey-small popover-wrapper" data-skill="'+skillName+'" data-year="'+exp+'" ><span class="d-flex justify-content-center align-items-center" onclick="editSkill(this)">'+((icon != '')?'<img src="'+icon+'" alt="'+skillName+'">':'')+' '+skillName+' ꞏ '+exp+'y </span><div class="popover-modal example-popover"><div class="popover-body"><div class="form-group"><label class="mb-5 text-start w-100">Years of experience:</label><input type="number" min="0" max="20" name="skill_exp" value="'+exp+'" class="form-control skill_exp"></div><div class="form-group d-flex"><button class="btn btn-border rounded-0 pl-10 pr-10 mr-10" type="button" name="cancel" onclick="cancelSkillUpdate(this)">Cancel</button><button class="btn btn-brand-1 rounded-0 pl-10 pr-10" type="button" name="save" onclick="saveSkillUpdate(this)">Save</button></div></div></div><span class="close-skill ml-5" onclick="deleteSkill(this)"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path fill="#231815" fill-rule="nonzero" d="M20.4 4.6l-1-1L12 11 4.6 3.6l-1 1L11 12l-7.4 7.4 1 1L12 13l7.4 7.4 1-1L13 12z"></path></g></svg></span></li></ul></div>');
                    }
                }
            }
           // console.log(addNewSkills);           
        }
    }
    function addNewSkill(e) {
        var listItem = e.closest('div.popover-wrapper');
        if (listItem) {
            $("input[name='skill_exp']", listItem).val('');
            $('#devSkillDrop').val('').trigger('change');
            // $('#devSkillDrop option').removeAttr("selected").first().attr("selected", "true");
            $("#select2-devSkillDrop-container").attr("title", "Choose Skill").text("Choose Skill");
            listItem.classList.add("open");
        }
    }
    function cancelSkillUpdate(e) {
        var listItem = e.closest('li');
        if (listItem) {
            listItem.classList.remove("open");
            $("input[name='skill_exp']", listItem).val(listItem.getAttribute('data-year'));
        }
    }
    function saveSkillUpdate(e) {
        var listItem = e.closest('li');
        if (listItem) {
            listItem.classList.remove("open");
            var exp = $("input[name='skill_exp']", listItem).val();
            listItem.setAttribute('data-year', exp);
            var skillName = listItem.getAttribute('data-skill');
            var firstSpan = listItem.querySelector('span');
            var img = listItem.querySelector('span:first-child img');
            if (firstSpan) {
                firstSpan.innerHTML = ((img !== null)?img.outerHTML:'')+skillName+' '+((exp != '0')?'ꞏ '+exp+'y':'');
            }
            editSkills.push({ 'skill_name': skillName, 'years_exp': exp });
        }
         
    }
    function deleteSkill(e) {
        var listItem = e.closest('li');
        if (listItem) {
            deleteSkills.push({ 'skill_name': listItem.getAttribute('data-skill') });
            // listItem.classList.add("d-none");;
            listItem.remove();
        }
    }
    function editSkill(e) {
        if($(".edit-developer-skill .courses").hasClass("edit-skills")) {
            $(".edit-developer-skill .courses li.btn").removeClass("open");
            var listItem = e.closest('li');
            if (listItem) {
                listItem.classList.add("open");
            }
        }
    }
    function editTitle() {
        $(".title-save-section").removeClass("d-none");
        $(".title-display-section").addClass("d-none");
    }
    function editDeveloperSkill() {

        toggleEditSkillWindow();
        deleteSkills = [];
        editSkills = [];
        addNewSkills = [];
    }
    function toggleEditSkillWindow() {
        $(".edit-developer-skill .save-icon, .edit-developer-skill .edit-icon, .edit-developer-skill .courses li.btn .close-skill, #addNewSkill, #cancelEditSkill").toggleClass("d-none");
        
        $(".edit-developer-skill .courses").toggleClass("edit-skills");
        $(".edit-developer-skill .courses li.btn").removeClass("open");
        
    }
    function saveDeveloperSkill() {
        Livewire.dispatch('updateSkills', { addNewSkills: addNewSkills,  editSkills: editSkills, deleteSkills: deleteSkills } );
        toggleEditSkillWindow();
        deleteSkills = [];
        editSkills = [];
        addNewSkills = [];
    }
    function cancelEditSkill() {
        deleteSkills = [];
        editSkills = [];
        addNewSkills = [];
        Livewire.dispatch('updateSkills', { addNewSkills: addNewSkills, editSkills: editSkills, deleteSkills: deleteSkills } );
       toggleEditSkillWindow();
    }
    function editDeveloperDescription() {
        $(".developer-description .save-icon").removeClass("d-none");
        $(".developer-description .edit-icon").addClass("d-none");
        $('.developer-description .content-single div:eq(1)').removeClass("d-none");
        $('.developer-description .content-single div:eq(0)').addClass("d-none");
        autoExpand($('.developer-description .content-single textarea').get(0));
    }
    function saveDeveloperDescription() {
        Livewire.dispatch('updateDeveloperFields', { fields:  { description: $('.developer-description .content-single textarea').val() } });
        $(".developer-description .save-icon").addClass("d-none");
        $(".developer-description .edit-icon").removeClass("d-none");
        $('.developer-description .content-single div:eq(1)').addClass("d-none");
        $('.developer-description .content-single div:eq(0)').removeClass("d-none");
         showToastMessage('Success', 'Description updated successfully.');
    }
    function saveTitle() {
        Livewire.dispatch('updateDeveloperFields', { fields:  { title: $("input[name='developerTitle']").val() } });
        $(".title-display-section").removeClass("d-none");
        $(".title-save-section").addClass("d-none");
        showToastMessage('Success', 'Title updated successfully.');
    }
    function openOverviewPopup() {
        $("#overviewPopup").modal("show");
    }
    function openProfileImagePopup() {
        if($("#profileImages img.lazy").length > 0) {
            $.each($('#profileImages img.lazy'), function() {
                if ( $(this).attr('data-src')) {
                    var source = $(this).data('src');
                    $(this).attr('src', source);
                    $(this).removeAttr('data-src').removeClass("lazy");
                }
            });
        }
        $("#profileImages").modal("show");
    }
    function selectAvatarImage(e, avatarImage) {
        $("img.avatar").removeClass("border");
        $(e).addClass("border");
        $("input[name='profile_image_name']").val(avatarImage);
    }
    function updateProfileImage() {
        Livewire.dispatch('updateDeveloperFields', { fields:  { profile_image: $("input[name='profile_image_name']").val() } });

       
        $("#profileImages").modal("hide");
        showToastMessage('Success', 'Profile image updated.');
    }
    /* Education start */
    function deleteEducationSkill(e) {
        var listItem = e.closest('li');
        if (listItem) {
            listItem.remove();
        }
    }
    function editEducation(e) {
        $(".education-skills-section .save-icon, .education-skills-section .edit-icon, .education-skills li>span, .education-skills li div, .education-skills>div").toggleClass("d-none");
        //$("").toggleClass("d-none");
    }
    function saveEducation(e) {
        var educationValues = $('.education-skills ul li input[type="text"]').map(function() {
            return $(this).val().trim();
        }).get().filter(function(value) {
            // Filter out empty values
            return value !== '';
        }).join(';');
        $(".education-skills-section .save-icon, .education-skills-section .edit-icon, .education-skills li>span, .education-skills li div, .education-skills>div").toggleClass("d-none");
        Livewire.dispatch('updateDeveloperFields', { fields:  { education: educationValues } });
        showToastMessage('Success', 'Saved education detail.');
    }
    function addNewEducationSkill(e) {
        $('.education-skills ul').append('<li class=""><span class="d-none"></span><div class="form-group d-flex"><input type="text" value="" class="form-control mb-10 pr-25"><span class="close-education-skill  " onclick="deleteEducationSkill(this)"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path fill="#231815" fill-rule="nonzero" d="M20.4 4.6l-1-1L12 11 4.6 3.6l-1 1L11 12l-7.4 7.4 1 1L12 13l7.4 7.4 1-1L13 12z"></path></g></svg></span></div></li>');
        
    }
    /* Education end */
    /* Soft Skills start */
    function deleteSoftSkill(e) {
        var listItem = e.closest('li');
        if (listItem) {
            listItem.remove();
        }
    }
    function editSoftSkill(e) {
        $(".soft-skills-section .save-icon, .soft-skills-section .edit-icon, .soft-skills li>span, .soft-skills li div, .soft-skills>div").toggleClass("d-none");
        //$("").toggleClass("d-none");
    }
    function saveSoftSkill(e) {
        var softSkillValues = $('.soft-skills ul li input[type="text"]').map(function() {
            return $(this).val().trim();
        }).get().filter(function(value) {
            // Filter out empty values
            return value !== '';
        }).join(';');
        $(".soft-skills-section .save-icon, .education-skills-section .edit-icon, .soft-skills li>span, .soft-skills li div, .soft-skills>div").toggleClass("d-none");
        Livewire.dispatch('updateDeveloperFields', { fields:  { softskills: softSkillValues } });
        showToastMessage('Success', 'Saved soft skills detail.');
    }
    function addNewSoftSkill(e) {
        $('.soft-skills ul').append('<li class=""><span class="d-none"></span><div class="form-group d-flex"><input type="text" value="" class="form-control mb-10 pr-25"><span class="close-soft-skill  " onclick="deleteSoftSkill(this)"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path fill="#231815" fill-rule="nonzero" d="M20.4 4.6l-1-1L12 11 4.6 3.6l-1 1L11 12l-7.4 7.4 1 1L12 13l7.4 7.4 1-1L13 12z"></path></g></svg></span></div></li>');
    }
    /* Soft Skills end */
    /* Edit Private Information */
    function openUpdateCVPopup() {
        $("#updateCVPopup").modal('show');
    }
    function editPrivateInformation() {
        $(".profile-information .profile-form input").removeAttr("disabled");
        $(".profile-information .save-icon").removeClass("d-none");
        $(".profile-information .edit-icon").addClass("d-none");
    }
    /* Edit Private Information end */
    function validatePhoneCode() {
        if($("#phoneVerificationPopup input[name='validateCode']").val() != '') {
            Livewire.dispatch('validatePhoneCode'); // { addNewSkills: addNewSkills,  editSkills: editSkills, deleteSkills: deleteSkills }
        } else {
            showToastMessage('Error', "Code wasn't inserted");
        }
    }
    function createDeveloper(responseText) {
      $(".addpercentage").html('<span style="display: block;">Converting CV to Developer Profile...</span><span style="font-size: 13px; display: block;">This process can take up to 60 seconds</span>').show();
      $.ajax({
        url: "{{ route('developer.add') }}",
        type: "POST",
        data: { _token: '{{csrf_token()}}', 'filename': responseText.filename , 'content': responseText.content },
        success: function(data){
            if(data.not_developer != undefined ) {
                showToastMessage('Error', "Uploaded CV isn't a developer");
            } else {
                if ($("#updateCVPopup").is(":visible")) {
                    $("#updateCVPopup").modal('hide');
                }
              Livewire.dispatch('uploadedCV');
              Livewire.dispatch('updateSkills', { addNewSkills: [],  editSkills: [], deleteSkills: [] } );
              showToastMessage('Success', 'Developer account created successfully');

            }
            if($(".dz-preview .dz-remove").length > 0) {
                $(".dz-preview .dz-remove").get(0).click();
            }
            $(".dz-default").show();
            $(".addpercentage").hide();
            $(".upload-developer-cv img").addClass("d-none");
            $(".upload-developer-cv").removeClass("disabled").removeAttr("disabled");
        },
        error: function(data){
            // showToastMessage('Error', 'Error while creating a developer. Try again!'); 
          $(".addpercentage").hide();
          $(".upload-developer-cv img").addClass("d-none");
          $(".upload-developer-cv").removeClass("disabled").removeAttr("disabled");
        }
      });
    }
    function setupDragon(uploader) {
        var dragon = (function (elm) {
          var dragCounter = 0;

          return {
            enter: function (event) {
                $(".dz-preview").hide();
                $(".dz-default").show();
                $(".addpercentage").hide();
                $("#articleText").css("height","calc(100vh - 405px)");
                $(".upload").html('<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="20" fill="#F6F2FE"></circle><g clip-path="url(#clip0_9045_57066)"><path d="M13.5638 19.6723L10.1877 25.9514L9.79214 14.6238C9.74223 13.1947 10.8636 11.9922 12.2927 11.9423L17.0496 11.7762C17.7378 11.7522 18.4072 12.0004 18.91 12.4692L20.0203 13.5046C20.5231 13.9734 21.1925 14.2216 21.8807 14.1976L26.6336 14.0316C28.0627 13.9817 29.2652 15.1031 29.3151 16.5322L29.3603 17.8277L15.7575 18.3027C14.8344 18.3349 14.0014 18.8545 13.5637 19.6683L13.5638 19.6723ZM14.7039 20.2851C14.9248 19.8761 15.3414 19.6184 15.8029 19.6023L31.9967 19.0367C32.4623 19.0205 32.896 19.2526 33.1409 19.6494C33.3858 20.0462 33.403 20.5401 33.1822 20.9491L28.9194 28.8805C28.7025 29.2853 28.2859 29.543 27.8244 29.5591L11.6305 30.1246C11.165 30.1409 10.7312 29.9088 10.4863 29.512C10.2414 29.1152 10.2242 28.6213 10.445 28.2123L14.7078 20.2809L14.7039 20.2851Z" fill="url(#paint0_linear_9045_57066)"></path></g><defs><linearGradient id="paint0_linear_9045_57066" x1="21.3605" y1="11.6257" x2="21.9938" y2="29.7628" gradientUnits="userSpaceOnUse"><stop stop-color="#E404DD"></stop><stop offset="1" stop-color="#4D00E8"></stop></linearGradient><clipPath id="clip0_9045_57066"><rect width="23.3333" height="23.3333" fill="white" transform="translate(9.6001 9.11789) rotate(-2)"></rect></clipPath></defs></svg>Drop files here');
              event.preventDefault();
              dragCounter++;
              elm.classList.add('dz-drag-hover')
            },
            leave: function (event) {
              dragCounter--;
              if (dragCounter === 0) {
                $(".dz-default").hide();
                $(".dz-preview").show();
                elm.classList.remove('dz-drag-hover');
              }
              if (!$(".dropzoneSubmit").hasClass("dz-preview")) {
                $(".dz-default").show();
                $(".dz-preview").hide();
              }
            }
          }
        })(uploader.element);

        uploader.on('dragenter', dragon.enter);
        uploader.on('dragleave', dragon.leave);
    }
    function initDropzone() {
          
      // $(document).on('ready livewire:navigated', function() {
        Dropzone.autoDiscover = false;
        console.log($(".dropzoneSubmit").length);
        if($(".dropzoneSubmit").length > 0) {
          myDropzone =$(".dropzoneSubmit").dropzone({
              url: "{{ url('/upload-file-read-data') }}",
              maxFilesize: 5, // 50 mb
              addRemoveLinks : true,
              autoProcessQueue: false,
              maxFiles:1,
              acceptedFiles: ".pdf,.docx,.doc",
              dictDefaultMessage: '<div class="upload"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.125 6.85706H11.375C11.1751 6.85706 11 7.07343 11 7.26318V9.96993C11 10.1863 10.8249 10.3761 10.625 10.3761H2.375C2.17513 10.3761 2 10.1867 2 9.96993V7.26318C2 7.07381 1.82487 6.85706 1.625 6.85706H0.875C0.675125 6.85706 0.5 7.07343 0.5 7.26318V10.9172C0.5 11.5127 0.95 11.9998 1.50013 11.9998H11.5002C12.0504 11.9998 12.5004 11.5127 12.5004 10.9172V7.26318C12.5004 7.07381 12.3252 6.85706 12.1254 6.85706H12.125ZM6.76251 0.107156C6.61266 -0.0357188 6.38734 -0.0357188 6.23749 0.107156L2.86239 3.32578C2.71254 3.46866 2.71254 3.68353 2.86239 3.82641L3.38741 4.32703C3.53726 4.46991 3.76258 4.46991 3.91244 4.32703L5.3125 2.99166C5.46235 2.84878 5.76241 2.94403 5.76241 3.15853V8.21316C5.76241 8.40403 5.91227 8.57091 6.11243 8.57091H6.86241C7.06258 8.57091 7.26238 8.38003 7.26238 8.21316V3.18253C7.26238 2.96803 7.51249 2.87241 7.6875 3.01566L9.08756 4.35103C9.23742 4.49391 9.46274 4.49391 9.61259 4.35103L10.1376 3.85041C10.2875 3.70753 10.2875 3.49266 10.1376 3.34978L6.76251 0.107156Z" fill="#7B3FF2"></path></svg><strong>Upload your recent resume or CV</strong><span>You can drag & drop as well. Formats: PDF or Doc</span></div>',
              dictResponseError: 'Error uploading file!',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              init: function() {
                  let myDropzoneObj = this;
                  setupDragon(this),
                  $(".upload-developer-cv").click(function (e) {
                      e.preventDefault();
                      if(myDropzoneObj.files.length > 0){
                          $(".upload-developer-cv img").removeClass("d-none");
                          $(this).addClass("disabled").attr("disabled", "disabled");
                       

                          myDropzoneObj.processQueue();
                      }
                  });
                  this.on('sending', function(file, xhr, formData) {
                     $(".addpercentage").text("Uploading file").show();
                  });

                  this.on('addedfile', function(file){

                    
                      $("#articleText").css("height","calc(100vh - 425px)");
                          $(".dz-image").html("");
                          $(".dz-details").html("");
                          $(".dz-preview").show();
                          $(".dz-default").hide();
                          var preview = document.getElementsByClassName('dz-preview');
                          preview = preview[preview.length - 1];
                          var imageName = document.createElement('span');
                          if(file.size < 1000000){
                              var _size = Math.floor(file.size/1000) + 'KB';
                          } else {
                              var _size = Math.floor(file.size/1000000) + 'MB';
                          }
                          imageName.innerHTML = "<img src='{{ asset('/images/File Success.svg') }}'> "+file.name+" ("+_size+")";
                          preview.insertBefore(imageName, preview.firstChild);
                          $(".showBrowseButton").show();
                      });
                  this.on("success", function(file, responseText) {
                   // $(".addpercentage").hide();
                     createDeveloper(responseText);
                    //$(".dz-default").show();
                  });
                  this.on("complete", function(file) {
                     // $(".addpercentage").hide();
                      $("#articleText").css("height","calc(100vh - 405px)");
                      $(".dz-remove").html('<div><span class="" style="font-size: 1.5em"><svg width="15" height="15" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.0244 1.69478H8.5162L8.31294 0.881332C8.24505 0.339033 7.63487 0 6.68566 0H5.53317C4.65184 0 3.97378 0.339033 3.90589 0.881332L3.77013 1.69478H1.26152C1.19363 1.69478 1.12575 1.76266 1.12575 1.83055V2.77976C1.12575 2.84765 1.19363 2.91553 1.26152 2.91553H11.0244C11.0923 2.91553 11.1602 2.84765 11.1602 2.77976V1.83055C11.1602 1.76266 11.0923 1.69478 11.0244 1.69478ZM5.12591 1.28822C5.15076 1.28822 5.18465 1.27913 5.22762 1.2676C5.30205 1.24762 5.40372 1.22034 5.53282 1.22034H6.75319C6.95646 1.22034 7.09222 1.22034 7.22761 1.28822L7.29549 1.69514H4.99053L5.12629 1.28822H5.12591ZM7.56662 9.55931H6.6174C6.54952 9.55931 6.48164 9.55931 6.48164 9.49143V4.13555C6.48164 4.1067 6.48164 4.09011 6.48684 4.07537C6.49389 4.05541 6.51048 4.03882 6.54952 3.99978C6.54952 3.9319 6.6174 3.9319 6.6174 3.9319H7.56662L7.6345 3.99978C7.70238 3.99978 7.70238 4.06767 7.70238 4.06767V9.42354C7.70238 9.49143 7.6345 9.55931 7.56662 9.55931ZM4.58358 9.55931H5.5328C5.60068 9.55931 5.66856 9.49143 5.66856 9.42354V4.06767C5.66856 4.06767 5.66856 3.99978 5.60068 3.99978L5.5328 3.9319H4.58358C4.44782 3.99978 4.38031 4.06767 4.38031 4.13517V9.49104C4.38031 9.49104 4.38031 9.55893 4.4482 9.55893H4.58396L4.58358 9.55931ZM10.0752 3.38952L11.0244 3.45741H11.0241C11.0919 3.45741 11.0919 3.52529 11.0241 3.59317L10.6172 9.96615C10.5493 11.1186 9.53217 12 8.37969 12H3.76938C2.61651 12 1.5998 11.0507 1.53192 9.96615L1.125 3.59317C1.125 3.52529 1.19288 3.45741 1.26077 3.45741H2.34536C2.41325 3.45741 2.41325 3.52529 2.41325 3.52529L2.82016 9.89826C2.82016 10.3727 3.29496 10.7796 3.83726 10.7796H8.44757C8.99025 10.7796 9.46467 10.3727 9.46467 9.89826L9.87158 3.52529L10.0073 3.38952H10.0752Z" fill="#7B3FF2"/></svg></span></div>');
                      $(".dz-image").html("");
                      $(".dz-details").html("");
                  });
                  this.on('error', function(file, response) {
                      $(".dz-image").html("");
                      $(".dz-details").html("");
                      $(".dz-preview").show();
                      $(".dz-default").hide();
                      var preview = document.getElementsByClassName('dz-preview');
                      preview = preview[preview.length - 1];
                      var imageName = document.createElement('span');
                      if(file.size < 1000000){
                          var _size = Math.floor(file.size/1000) + 'KB';
                      } else {
                          var _size = Math.floor(file.size/1000000) + 'MB';
                      }

                      imageName.innerHTML = "<img src='{{ asset('/images/File.svg') }}'> "+file.name+" ("+_size+")";
                      preview.insertBefore(imageName, preview.firstChild);
                      if(response == "You can't upload files of this type.") {
                          var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
                          errorDisplay[errorDisplay.length - 1].innerHTML = "Unsupported file type. Use ShareFile link after submitting the request.";
                      }
                      if(response.indexOf('File is too big') != -1){
                          var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
                          errorDisplay[errorDisplay.length - 1].innerHTML = "File is too large ("+_size+"). Maximum file size: 5MB.";
                      }

                      $('span:nth-child(2)').remove();
                      $(".upload-developer-cv img").addClass("d-none");
                      $(".upload-developer-cv").removeClass("disabled").removeAttr("disabled");
                  });
                  this.on("totaluploadprogress", function(progress) {

                     // $(".addpercentage").show();
                      if(progress.toFixed(0) != 100) {
                        $(".addpercentage").text("Uploading file "+ progress.toFixed(0) + "%");
                      }
                      var total = this.files.length;
                      if(total == 0) {
                       //  $(".addpercentage").hide();
                      }if(progress.toFixed(0) == 100) {
                         // $(".addpercentage").hide();
                      }

                  });
              },

              removedfile: function(file) {
                  var total = this.files.length;
                  if(total == 0) {
                      $(".addpercentage").hide();
                      $("#articleText").css("height","calc(100vh - 405px)");
                      $(".dz-default").show();
                      $("#articleText").val('');
                      $(".upload").html('<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.125 6.85706H11.375C11.1751 6.85706 11 7.07343 11 7.26318V9.96993C11 10.1863 10.8249 10.3761 10.625 10.3761H2.375C2.17513 10.3761 2 10.1867 2 9.96993V7.26318C2 7.07381 1.82487 6.85706 1.625 6.85706H0.875C0.675125 6.85706 0.5 7.07343 0.5 7.26318V10.9172C0.5 11.5127 0.95 11.9998 1.50013 11.9998H11.5002C12.0504 11.9998 12.5004 11.5127 12.5004 10.9172V7.26318C12.5004 7.07381 12.3252 6.85706 12.1254 6.85706H12.125ZM6.76251 0.107156C6.61266 -0.0357188 6.38734 -0.0357188 6.23749 0.107156L2.86239 3.32578C2.71254 3.46866 2.71254 3.68353 2.86239 3.82641L3.38741 4.32703C3.53726 4.46991 3.76258 4.46991 3.91244 4.32703L5.3125 2.99166C5.46235 2.84878 5.76241 2.94403 5.76241 3.15853V8.21316C5.76241 8.40403 5.91227 8.57091 6.11243 8.57091H6.86241C7.06258 8.57091 7.26238 8.38003 7.26238 8.21316V3.18253C7.26238 2.96803 7.51249 2.87241 7.6875 3.01566L9.08756 4.35103C9.23742 4.49391 9.46274 4.49391 9.61259 4.35103L10.1376 3.85041C10.2875 3.70753 10.2875 3.49266 10.1376 3.34978L6.76251 0.107156Z" fill="#7B3FF2"></path></svg><strong>Upload your recent resume or CV</strong><span>You can drag & drop as well. Formats: PDF or Doc</span>');
                      $(".showBrowseButton").hide();
                  }
                  var name = file.name;
                 /* name = name.replace(/ /g, "_");
                  name = name.replace("&", "");*/
                 //  $.ajax({
                 //   type: 'POST',
                 //   url: "{{url('/RemoveTicketsImage')}}",
                 //   data: {name: name,_token: "{{ csrf_token() }}"},
                 //   sucess: function(data){
                 //      console.log('success: ' + data);
                 //   }
                 // });
                 var _ref;
                  return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
               },
          });
          
        }
    //});
    }
    //document.addEventListener('livewire:initialized', () => {
    Livewire.on('hideFirstCVUpload', (data) => {
        $(".first-section-upload-cv").hide();
    });
    Livewire.on('initDropzone', (data) => {
      
      console.log("initDropzone");
      initDropzone();

    });
    //});
  </script>

@endsection
<div>
    <div class="job-overview edit-developer-skill" wire:key="skillsSection">
        <div class="d-flex flex-row justify-content-between align-items-start border-bottom pb-15 mb-30">
            <h5 class="m-0">Skills ({{ $totalSkills }})</h5>
            <div class="d-flex">
                <div class=" popover-wrapper">
                    <button type="button" class="btn btn-border mr-10 d-none" id="addNewSkill" onclick="addNewSkill(this)">Add New Skill</button>
                    <div class="popover-modal example-popover">
                        <div class="popover-body">

                             <div class="form-group select-style select-style-icon" wire:ignore>
                                <select id="devSkillDrop" name="developer_skill" class="form-control form-icons developer-skill-active"  onchange="changeJobsCity(this)">
                                  <option value="" disabled  selected  >Choose Skill</option>
                                  @foreach($skills as $skill)
                                    <option value="{{ $skill['display_name'] }}" data-category="{{ $skill['category_id'] }}" data-icon="{{ $skill['icon'] }}">{{ $skill['display_name'] }}</option>
                                  @endforeach
                                </select>
                              </div>
                            <div class="form-group">
                                <label class="mb-5 text-start w-100">Years of experience:</label>
                                <input type="number" min="0" max="20" name="skill_exp" value="" class="form-control skill_exp">
                            </div>
                            <div class="form-group d-flex">
                                <button class="btn btn-border rounded-0 pl-10 pr-10 mr-10" type="button" name="cancel" onclick="cancelAddNewSkill(this)">Cancel</button>
                                <button class="btn btn-brand-1 rounded-0 pl-10 pr-10" type="button" name="save" onclick="saveAddNewSkill(this)">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-border mr-10 d-none"  id="cancelEditSkill" onclick="cancelEditSkill()">Cancel</button>
                <a href="javaScript:;" onclick="editDeveloperSkill()" class="edit-icon">
                    {!! loadEditIconImg() !!}
                </a>
                <button type="button" class="btn btn-border save-icon d-none d-flex align-items-center justify-content-center" onclick="saveDeveloperSkill()">
                    {!! loadSaveIconImg() !!}
                </button>
            </div>
        </div>
        <div class="row developer-skills" >
            @php $categoryId = ''; @endphp
            @foreach($developer['categories'] as $key => $category)
             <div class="developer-category mb-3" id="category-{{ $category['category_id'] }}" wire:key="category-{{ $category['category_id'] }}"> 
                <label>{{ $categories[$category['category_id']] }}</label>
             <ul class="courses" wire:key="skillsList-{{ $category['category_id'] }}">
            @foreach($category['developer_skills'] as $key => $skill)
                

                <li class="btn btn-grey-small popover-wrapper" data-skill="{{ $skill['skill_name'] }}" data-year="{{ $skill['years_exp'] }}" wire:key="skillsItem-{{ $category['category_id'].'-'.$key }}">
                    <span class="d-flex justify-content-center align-items-center" onclick="editSkill(this)">
                        @if($skill['icon'] != '')
                            <img src="{{ $skill['icon'] }}" alt="{{ $skill['skill_name'] }}">
                        @endif
                        {{ $skill['skill_name'] }} @if($skill['years_exp'] > 0) ꞏ {{ $skill['years_exp'] }}y @endif
                    </span>
                    <div class="popover-modal example-popover">
                        <div class="popover-body">
                            <div class="form-group">
                                <label class="mb-5 text-start w-100">Years of experience:</label>
                                <input type="number" min="0" max="20" name="skill_exp" value="{{ $skill['years_exp'] }}" class="form-control skill_exp">
                            </div>
                            <div class="form-group d-flex">
                                <button class="btn btn-border rounded-0 pl-10 pr-10 mr-10" type="button" name="cancel" onclick="cancelSkillUpdate(this)">Cancel</button>
                                <button class="btn btn-brand-1 rounded-0 pl-10 pr-10" type="button" name="save" onclick="saveSkillUpdate(this)">Save</button>
                            </div>
                        </div>
                    </div>
                    <span class="close-skill d-none ml-5" onclick="deleteSkill(this)">{!! loadCloseIconImg() !!}</span>
                </li>

                

               
            @endforeach
            </ul>
            </div>

             @endforeach
        </div>
    </div>
</div>

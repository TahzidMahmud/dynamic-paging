<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                       <div v-if="selectedItems==null"> <button class="btn btn-primary" @click="openModal">Add New Section</button></div>
                       <div v-else><h6 class="text text-warning">Sections Can Be added One at a Time</h6></div>
                    </div>

                    <div class="card-body">
                        <div v-for="(section , index) in sections" :key="index" class="row d-flex flex-column">
                            <div class="col-12">
                                <h6>{{ section }} Order: <input class="control" type="number" min="0" :value="index+1"/></h6>
                                <button class="btn btn-primary" @click="openItemModal">Add Item</button>
                            </div>
                            <hr/>
                            <div class="col-md-12" >
                                <div v-if="selectedItems" class="row">
                                    <h6>Selected Item Is:  {{ selectedItems.text }} </h6>
                                    <hr>
                                    <div class="col-12" v-for="(attr,index) in selected_attr_arr" :key="index">
                                        <h6>Item Will Have {{ attr.label }} In Order: <input class="control" type="number" min="0" :value="index+1"/></h6>
                                        <AttributeComponent :attribute="attr"></AttributeComponent>
                                        <div class="m-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div ref="addSectionModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
                <div class="modal-content">
                    <div class="modal-header bord-btm">
                        <h4 class="modal-title h6">Add New Section</h4>
                        <button type="button" class="close btn btn-primary" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class="form-horizontal" >
                        <div class="modal-body">
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="phone">Section Name</label>
                                    <div class="col-sm-10">
                                        <input v-model="section"  placeholder="Amount" name="advanced_payment_amount" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ref="closeBtn" type="button" class="btn btn-styled btn-base-3" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-styled btn-base-1" @click="addNewsection()" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div ref="addItemModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
                <div class="modal-content">
                    <div class="modal-header bord-btm">
                        <h4 class="modal-title h6">Add Item</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class="form-horizontal" >
                        <div class="modal-body v-dropdown-container" >
                            <div class="form-group">
                                <div class=" row">
                                    <label class="col-sm-2 control-label" for="phone">Select Item</label>
                                    <div class="col-sm-10">
                                        <VueSelectPicker
                                            v-model="selectedItems"
                                            :options="items_arr"
                                            :searchable="srcable"
                                            add-class="form-control"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 control-label" for="phone">Select Attributes</label>
                                    <div class="col-sm-10">
                                        <multiselect
                                            v-model="selected_attr_arr"
                                            :options="attr_arr"
                                            track-by="value"
                                            label="label"
                                            id="myMultiselect"
                                            :multiple="true"
                                            :close-on-select="false"
                                            :clear-on-select="false"
                                            ></multiselect>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ref="closeBtn" type="button" class="btn btn-primary btn-base-3" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueSelectPicker from "vue-select-picker-bootstrap";
import Multiselect from 'vue-multiselect';
// import AttributeComponent from "./AttributeComponent.vue";
export default {
    components: {
        VueSelectPicker,
        Multiselect,
        // AttributeComponent
    },
    props:{
        items:{
            type:Array,
        },
    },
    data:()=>{
        return {
           sections: [],
           items_arr:[],
           attr_arr:[],
           selected_attr_arr:[],
           selectedItems:null,
           section:'',
           srcable:true
        };
    },
    created(){
        this.items.forEach((el)=>{
            this.items_arr.push({value:el.type,text:el.name});
        })

    },
    watch:{
        selectedItems:function(prev){
           this.items_arr=[...this.items.filter((item)=>{
            if(item.type==prev.value){
                return item;
            }
           })];

           this.attr_arr=[...this.items_arr[0].attributes.map((attr)=>{
            return ({value:attr.name,label:attr.value});
           })];
        },

    },
    computed:{

    },
    methods:{
        openItemModal(){
            let el =this.$refs.addItemModal;
            window.$(el).modal('show');
        },
        openModal(){
            let el =this.$refs.addSectionModal;
            window.$(el).modal('show');
        },
        addNewsection(){
            this.sections=[...this.sections,this.section];
            this.section='';
            let el =this.$refs.addSectionModal;
            window.$(el).modal('hide');
        },
        addItem(){
            console.log(this.selected_attr_arr)
        }

    }


}
</script>
<style>
.v-dropdown-container{
    height: 50vh!important;
    overflow-y:scroll;
}

.d-block{
    display: block!important;
}
.bord-btm{
    border-bottom: 1px solid red;
}
.control{
    padding: 0.6rem 1rem;
    font-size: 0.875rem;
    height: calc(1.3125rem + 1.2rem + 2px);
    border: 1px solid #e2e5ec;
    color: #898b92;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


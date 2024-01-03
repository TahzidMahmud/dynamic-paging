<template>
   <div class="row">
        <div class="col-12">
            <label>Add Points To The List</label>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-8" lass="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="text" v-model="text" class="form-control" placeholder="Enter Points To The List...">
                    </div>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary mb-2" @click="addToList">Add</button>
                </div>
            </div>
        </div>
        <div v-if="list.length>0" class="col-12">
            <div v-for="(item,index) in list" :key="index" class="row d-flex align-items-center m-2">
                <div class="col-10">- {{ item }}</div>
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <button class="btn btn-sm btn-danger text-white" @click="removeFromList(index)">X</button>
                </div>
            </div>
        </div>
        <div v-else><h6 class="text text-warning">No Points Added Yet..!!</h6></div>
   </div>
</template>

<script>
export default {
    props:{
        attr_key:{
            type:String,
        },
    },
    data:()=>{
        return {
            text:'',
            list:[],
        }
    },
    methods:{
        handleChange(){
            this.$emit('handleChange',{"attr_key":this.attr_key,value:this.list});
        },
        removeFromList(ind){
            this.list=this.list.filter((item,index)=>{
                if(index!=ind){
                    return item;
                }
            });
            this.handleChange();
        },
        addToList(){
            this.list=[...this.list,this.text];
            this.text='';
            this.handleChange();
        },

    }
}
</script>

<style>

</style>

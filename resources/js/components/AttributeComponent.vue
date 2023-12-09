<template>
   <div>
        <div v-if="attribute.value=='list'">
            <ListComponent :attr_key="attribute.value"  @handleChange="handleChange"></ListComponent>
        </div>
        <div v-else-if="attribute.value=='title'">
            <TitleComponent :attr_key="attribute.value" @handleChange="handleChange"></TitleComponent>
        </div>
        <div v-else>Error loading Component.</div>
   </div>
</template>

<script>

export default {

    props:{
        attribute:{
            type:Object,
        },
    },
    data:()=>{
        return {
          values:[]
        };
    },
    created(){

    },
    methods:{
        handleChange(data){
            this.values=[...this.values,data];
        }
    }

}
</script>

<style>

</style>

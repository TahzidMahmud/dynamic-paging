<template>
   <div>
        <div v-if="attribute.value=='list'">
            <ListComponent :attr_key="attribute.value"  @handleChange="handleChange"></ListComponent>
        </div>
        <div v-else-if="attribute.value=='title'">
            <TitleComponent :attr_key="attribute.value" @handleChange="handleChange"></TitleComponent>
        </div>
        <div v-else-if="attribute.value=='sub_title'">
            <SubTitleComponent :attr_key="attribute.value" @handleChange="handleChange"></SubTitleComponent>
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
          values:{}
        };
    },
    created(){

    },
    methods:{
        handleChange(data){
           let key= data.attr_key;
           let val=data.value;
           this.values={...this.values,[key]:val};
           this.$emit('handleChange',{[key]:val});
        }
    }

}
</script>

<style>

</style>

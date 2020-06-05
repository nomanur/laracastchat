<template>
	<div class="row">
		<div class="col-lg-8">  
      <ul>
        <li v-for="tasks in project.tasks" v-text='tasks.body'></li>
      </ul>

      <input type="text" @keypress.enter="save()" v-model="newTask" @keydown="tapParticipants">
      <span v-if="activePeer" v-text="activePeer.name + ' is typing....' "></span>
    </div>

    <div class="col-lg-4">
      <h2>Active</h2>
    </div>
	</div>
</template>

<script>
export default {

  name: 'TaskList',
  props: { dataproject: { type: Object, required: true } },
  data() {
    return {
    	project: this.dataproject,
    	newTask:'',
      activePeer:false,
      typingTimer:false
    };
  },
  created(){
    Echo.private('tasks.'+this.project.id)
    .listen('TaskCreated', (e) => {
        //console.log(e);
        this.addTask(e.task)
    })
    .listenForWhisper("typing", e =>{
      this.activePeer=e

      if (this.typingTimer) clearTimeout(this.typingTimer);

     this.typingTimer = setTimeout(()=>{
        this.activePeer=false
        console.log('ok')
      }, 3000);
    });
  },
  methods:{
    tapParticipants(){
       Echo.private('tasks.'+this.project.id)
        .whisper('typing',{
          name: window.App.user.name
        })
    },
  	save(){
  		axios.post(`/api/projects/${this.project.id}/tasks`, {body: this.newTask})
  			.then(response=>response.data)
  			.then(this.addTask);
  	},
  	addTask(task){
      this.activePeer=false
  		this.project.tasks.push(task)
  		this.newTask='';
  	}
  }
};
</script>

<style lang="css" scoped>
</style>

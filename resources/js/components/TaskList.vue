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
      <ul>
        <li v-for="participant in participants" v-text="participant.name"></li>
      </ul>
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
      typingTimer:false,
      participants:[]
    };
  },
  computed:{
    channel(){
      //return Echo.private('tasks.'+this.project.id)
      return Echo.join('tasks.'+this.project.id)
    }
  },
  created(){
    this.channel
      .here(users=>{
        this.participants= users
      })
      .joining(user=>{
        this.participants.push(user)
      })
      .leaving(user=>{
        this.participants.splice(this.participants.indexOf(user), 1)
      })
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
       this.channel
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

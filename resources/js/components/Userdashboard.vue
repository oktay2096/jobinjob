<template>
    <div>
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-12 ">
                        <div class="card mb-4">
                        <div class="card-header">
                          Welcome {{name}}. Tasks shown belong {{date}} to date  <span @click="beforeday()">Previous Day</span> <span @click="nextday()">> Next Day</span>
                        </div>
                            <div class="card-body">
                                <table class="table">
                                        <thead>
                                            <tr>
                                            
                                            <th scope="col">Task</th>
                                            <th scope="col">Admin</th>
                                            
                                         
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th >{{tasklist.task}}</th>
                                                <td>{{tasklist.admin}}</td>
                                            </tr>
                                            
                                        </tbody>
                                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>
<style>
    span{
        cursor: pointer;
    }
</style>
<script>
export default {
    data () {
            return {
                
                name: "",
                lastday:null,
                previousday:null,
                tasklist:[],
                date:"",

            }
        },
        async created() {
            {
                const requestOptions = {
                method: "get",
                headers: { "Content-Type": "application/json" }
            };

            
             const tasklistresponse = await fetch("/information-list?date="+this.date, requestOptions);
             const data = await tasklistresponse.json();

             this.tasklist = data.task;
             this.date = data.now_date;
             this.name = data.user;
             this.lastday = data.last_day;
             this.previousday = data.before_day;

           

            }
            
        },
          methods:{
              async nextday()
              {
                  const requestOptions = {
                    method: "get",
                    headers: { "Content-Type": "application/json" }
                };
                this.tasklist  =[];
                const tasklistresponse = await fetch("/information-list?date="+this.lastday, requestOptions);
                const data = await tasklistresponse.json();

                this.tasklist = data.task;
                this.date = data.now_date;
                this.name = data.user;
                this.lastday = data.last_day;
                this.previousday = data.before_day;
              },
              async beforeday()
              {
                  this.tasklist  =[];
                    const requestOptions = {
                    method: "get",
                    headers: { "Content-Type": "application/json" }
                };

                const tasklistresponse = await fetch("/information-list?date="+this.previousday, requestOptions);
                const data = await tasklistresponse.json();

                this.tasklist = data.task;
                this.date = data.now_date;
                this.name = data.user;
                this.lastday = data.last_day;
                this.previousday = data.before_day;
              }
          }
         
        
}
</script>
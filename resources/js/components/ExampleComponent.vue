<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Nuevo proyecto</div>

                    <div class="card-body">
                        <form @submit.prevent="submit_form()">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input required type="text" maxlength="255" v-model="project.name" class="form-control" aria-describedby="Nombre del proyecto" placeholder="Nombre del proyecto">
                            </div>
                            <div class="form-group">
                                <label>Fecha de inicio</label>
                                <input required type="date" maxlength="255" v-model="project.start_date" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Fecha de finalización</label>
                                <input required type="date" maxlength="255" v-model="project.end_date" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label>Asignatura</label>
                                <select v-model="project.subject" class="form-control">
                                    <option value="">Seleccione una asignatura</option>
                                    <option v-for="(item, index1) in subjects" v-bind:key="index1" v-bind:value="item.id">{{ item.name }}</option>
                                    <option value="other">Otro</option>
                                </select>
                                
                            </div>
                            <div v-if="project.subject == 'other'" class="form-group">
                                <label>Escriba la asignatura</label>
                                <input required type="text" maxlength="255" v-model="project.other_subject" class="form-control" >
                            </div>
                            <h5>Elija las tenologias usadas en el proyecto</h5>
                            <div v-if="technologies.length == 0">
                                <span>Aun no hay tecnologias usadas en proyectos, escribalas abajo</span>
                            </div>
                            <div v-else v-for="(item, index2) in technologies" v-bind:key="'A'+ index2">
                                <div class="form-check">
                                    <input v-model="project.techs" v-bind:value="item.id" type="checkbox" class="form-check-input" v-bind:id="'technology_'+item.id">
                                    <label class="form-check-label"  v-bind:for="'technology_'+item.id">{{item.name}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Añada las tecnologías que no aparezcan en la lista</label>
                                <input type="text" maxlength="255" v-model="technology" class="form-control" >
                                <button class="btn btn-primary" v-on:click="add_other_technology" type="button">Añadir</button>
                            </div>

                            <div v-for="(item, index3) in project.others_technologies" v-bind:key="'B'+ index3">
                                {{item}} <button type="button" v-on:click="delete_other_technology(index3)" class="btn btn-primary">Eliminar</button>
                            </div>
                            
                            <h5>Elija las habilidades aprendidas en el proyecto</h5>
                            <div v-if="skills.length == 0">
                                <span>Aun no hay habilidades aprendidas en proyectos, escribalas abajo</span>
                            </div>
                            <div v-else v-for="(item, index4) in skills" v-bind:key="'C'+ index4">
                                <div class="form-check">
                                    <input v-model="project.skills" v-bind:value="item.id" type="checkbox" class="form-check-input" v-bind:id="'skill_'+item.id">
                                    <label class="form-check-label"  v-bind:for="'skill_'+item.id">{{item.name}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Añada las habilidades que no aparezcan en la lista</label>
                                <input type="text" maxlength="255"  v-model="skill" class="form-control" >
                                <button class="btn btn-primary" v-on:click="add_other_skills" type="button">Añadir</button>
                            </div>

                            <div v-for="(item, index5) in project.others_skills" v-bind:key="'D'+ index5">
                                {{item}} <button type="button" v-on:click="delete_other_skills(index5)" class="btn btn-primary">Eliminar</button>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data(){
            return {
                project: {
                    name: '',
                    start_date: '',
                    end_date: '',
                    subject: '',
                    other_subject:'',
                    others_technologies: [],
                    techs: [],
                    others_skills: [],
                    skills: [],
                },
                subjects: [],
                technologies: [],
                skills: [],
                technology: '',
                skill: ''
            }
        },
        mounted() {
            this.get_subjects();
            this.get_technologies();
            this.get_skills();
            console.log('Component mounted.')
        },
        methods:{
            submit_form: function() {
                if(this.validate_dates() == false) {
                    alert('La fecha de inicio no puede ser mayor a la fecha finalización');
                    return;
                }
                if(this.validate_subject() == false){
                    alert('Elija o escriba una asignatura');
                    return;
                }
                if(this.validate_technologies() == false){
                    alert('Elija o escriba una tecnología usada en el proyecto');
                    return;
                }
                if(this.validate_skills() == false) {
                    alert('Elija o escriba una habilidad aprendida en el proyecto');
                    return
                }
                axios.post('/projects', this.project)
                .then(function (response) {
                    console.log(response);
                    window.location.replace("/");
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            get_subjects: function() {
                self = this;
                axios.get('/subjects')
                .then(function (response) {
                    self.subjects = response.data
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            get_technologies: function() {
                self = this;
                axios.get('/technologies')
                .then(function (response) {
                    self.technologies = response.data
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            add_other_technology: function (){
                if(this.technology != '')
                {
                    this.project.others_technologies.push(this.technology);
                    this.technology = '';
                }
            },
            delete_other_technology: function (index) {
                this.project.others_technologies.splice(index, 1);
            },
            get_skills: function () {
                self = this;
                axios.get('/skills')
                .then(function (response) {
                    self.skills = response.data
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            add_other_skills: function (){
                if(this.skill != '')
                {
                    this.project.others_skills.push(this.skill);
                    this.skill = '';
                }
            },
            delete_other_skills: function (index) {
                this.project.others_skills.splice(index, 1);
            },
            validate_dates: function() {
                if(moment(this.project.end_date).isBefore(this.project.start_date)){
                    return false;}
                else{
                    return true;}
            },
            validate_subject: function() {
                if(this.project.subject === '' && this.project.other_subject === '')
                {
                    return false;
                }
                else{
                    if(this.project.subject === 'other' && this.project.other_subject === '')
                    {
                        return false
                    }
                    else {
                        return true
                    }
                }
            },
            validate_technologies: function() {
                if(this.project.others_technologies.length == 0 && this.project.techs.length == 0)
                {
                    return false;
                }
                else {
                    return true;
                }
            },
            validate_skills: function() {
                if(this.project.others_skills.length == 0 && this.project.skills.length == 0)
                {
                    return false;
                }
                else {
                    return true;
                }
            }
        }
    }
</script>

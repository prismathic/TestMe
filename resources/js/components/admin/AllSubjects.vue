<template>

    <div class="text-center">
        <v-btn tile class="m-3" outlined @click="dialog=true">
            <v-icon>
                mdi-plus
            </v-icon>
            ADD NEW SUBJECT
        </v-btn>
        <table class="table table-bordered table-sm w-100 text-center">
            <thead>
                <tr>
                    <th rowspan="2">S/N</th>
                    <th rowspan="2">SUBJECT NAME</th>
                    <th :colspan="allclasses.length">
                        SUBJECT CLASSES
                    </th>
                    <th rowspan="2">OPTIONS</th>
                </tr>
                <tr>
                    <th v-for="single in allclasses" :key="single.id">
                        {{single.class}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <SingleSubject v-for="(subject,index) in subjects" :key="subject.id" :allclasses="allclasses" :subject="subject" :number="index+1" :yellow="yellow" @updateSubject="updateSubject"/>
            </tbody>
        </table>

        <v-dialog v-model="dialog" max-width="500" persistent>
            <v-card>
                <v-card-title class="headline">Add New Subject</v-card-title>
                <v-container>
                    <v-text-field v-model="name"  label="Subject Name"></v-text-field>

                    <v-select v-model="classes" :items="items" chips deletable-chips label="Classes taking this subject" multiple></v-select>

                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn :disabled="loading" color="green darken-1" text @click="name=null; classes.length = 0; dialog=false">CLOSE</v-btn>
                    <v-btn :loading="loading" :disabled="loading || !name || classes.length === 0" color="green darken-1" text @click="createSubject()">SAVE</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>

</template>

<script>
import SingleSubject from './SingleSubject'
export default {
    name: "AllSubjects",
    props: ['allsubjects', 'allclasses'],
    components: {
        SingleSubject
    },
    data() {
        return {
            subjects: this.allsubjects,
            name: null,
            items: this.allclasses.map((single) => {return {text: single.class, value: single.id}}),
            classes: [],
            dialog: false,
            loading: false,
            yellow:  "#e67d23",
            snackbar: false,
            snackbarText: '',
        }
    },
    methods: {
        updateSubject(subject, index) {
            this.subjects.splice(index,1,subject)
        },
        createSubject() {
            this.loading = true

            this.$http.post(`admins/subjects`, {
                name: this.name,
                classes: this.classes
            })
            .then(res => {
                this.loading = false
                this.dialog = false
                this.subjects.push(res.data.subject)
                this.subjects.sort((a, b) => (a.subject_name > b.subject_name) ? 1 : -1);
                this.snackbarText = res.data.message
                this.snackbar = true
            })
            .catch(err => {
                this.loading = false
                this.dialog = false
                console.log(err.response.data)
                alert("Sorry, there was an error creating this subject, please try again later")
            })
        },
    }
}
</script>

<style>

</style>

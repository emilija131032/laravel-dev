<template>
    <div class="container">
        <div class="col-md-3">

        </div>
        <div class="col-md-9">
            <div class="text-center" style="margin: 20px 0px 20px 0px;">
                <button type="button" class="c-btn c-btn--danger u-mr-small" data-toggle="modal"
                        data-target="#modalAdd">
                    Add new
                </button>
                <div class="c-modal modal fade" id="modalAdd" role="dialog" ref="addUser">
                    <div class="c-modal__dialog modal-dialog">
                        <div class="c-modal__content modal-content">
                            <div class="c-modal__header">
                                <h3 class="c-modal__title">Add new user</h3>
                                <span class="c-modal__close" data-dismiss="modal"><i class="fa fa-close"></i></span>
                            </div>
                            <div class="c-modal__body">
                                <form method="POST" @submit.stop.prevent="addUser"  enctype="multipart/form-data">
                                    <div class="c-field u-mb-xsmall">
                                        <label class="c-field__label" for="institution_email">Емаил адреса</label>
                                        <input class="c-input" v-bind:class="{ border: errors.email}" type="email" id="institution_email"
                                               v-model="institution.email">
                                        <p v-if="errors.email" class="u-color-danger u-mb-small"> {{errors.email}} </p>
                                    </div>
                                    <button class="c-btn c-btn--danger c-btn--fullwidth" type="submit">Add</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row u-mb-large">
                <div class="col-md-12">
                    <div class="c-table-responsive@wide">
                        <table class="c-table c-table--zebra">
                            <caption class="c-table__title" style="caption-side: top !important;">
                                <div class="row">
                                    <div class="c-field col-md-4">
                                        <p>Show all invited users</p>
                                    </div>
                                </div>
                            </caption>
                            <thead class="c-table__head c-table__head--slim">
                            <tr class="c-table__row">
                                <th class="c-table__cell c-table__cell--head">Name</th>
                                <th class="c-table__cell c-table__cell--head">Avatar</th>
                                <th class="c-table__cell c-table__cell--head">Email</th>
                                <th class="c-table__cell c-table__cell--head">Signed up</th>
                                <th class="c-table__cell c-table__cell--head">Status</th>
                                <th class="c-table__cell c-table__cell--head">
                                    <span class="u-hidden-visually">Actions</span>
                                </th>
                                <th class="c-table__cell c-table__cell--head">
                                    <span class="u-hidden-visually">Disable</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="u in users">
                                <tr class="c-table__row">
                                    <td class="c-table__cell">
                                        <div class="o-media">
                                            <div class="o-media__body">
                                                {{ u.name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="c-table__cell">
                                        <div class="o-media">
                                            <div class="o-media__body">
                                                {{ u.avatar }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="c-table__cell">
                                        <div class="o-media">
                                            <div class="o-media__body">
                                                {{ u.email }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="c-table__cell">
                                        <div class="o-media">
                                            <div class="o-media__body">
                                                {{ u.signed_up }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="c-table__cell">
                                        <div class="o-media">
                                            <div class="o-media__body">
                                                {{ u.status }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="c-table__cell">
                                        <a class="u-text-mute" href="#" @click="disableUser(u.id)">
                                              <span class="c-tooltip c-tooltip&#45;&#45;left"
                                                    aria-label="Disable">
                                                <i class="fa fa-trash-o"></i>
                                              </span>
                                        </a>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
                user: {}
            }
        },
        created() {
            this.axios
                .get('/users')
                .then(response => {
                    this.users = response.data;
                });
        },
        methods: {
            addUser() {
                this.axios
                    .post('/addUser', this.user)
                    .then(response => (
                        this.$router.push({name: 'home'})
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            disableUser(id) {
                this.axios
                    .post(`/disableUser/${id}`)
                    .then(response => {
                        console.log(response.data)
                    });
            }
        }
    }
</script>

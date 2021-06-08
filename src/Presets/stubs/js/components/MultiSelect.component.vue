<template>
    <div class="multiSelect" :class="{'multiSelect--active' : isOpen }"
         @blur="deactivate()"
         @focus="activate()"
         @keyup.esc="deactivate()"
         role="combobox"
         tabindex="-1">
        <div class="multiSelect-container">
            <div class="multiSelect__select" @mousedown.prevent.stop="toggle()"></div>
            <div class="multiSelect__tags">
                <div class="multiSelect__tags-wrap">
                    <span v-for="item in labels" class="multiSelect__tag">
                        <span>{{  item['name'] }}</span>
                        <i aria-hidden="true" tabindex="1" class="multiSelect__tag-icon"
                           @keypress.enter.prevent="removeElement( item )"  @mousedown.prevent="removeElement( item )">
                        </i>
                    </span>
                </div>
                <div class="multiSelect__spinner" style="display: none;"></div>
                <input name="labels" type="text" autocomplete="off" placeholder="Pick label" tabindex="0" class="multiSelect__input"
                       :style="multiSelect__input" v-model="search" ref="search"
                       @focus.prevent="activate()">
                <span v-if="isPlaceholderVisible" class="multiSelect__placeholder">Pick label</span>
            </div>
            <transition name="fade">
                <div v-if="isOpen" tabindex="-1" class="multiSelect__content">
                    <ul class="multiSelect__content-wrapper">
                        <li v-if="!!values" v-for="(item, index) in filteredValues" class="multiSelect__element">
                            <span class="multiSelect__option"
                                  :class="highlight(index, item)"
                                  @click.stop="select(item)"
                                  @mouseenter.self="pointerSet(index)"
                                  :key="index">
                                <span class="label__name">{{ item['name'] }}</span>
                            </span>
                        </li>
                        <li v-if="showNoResults && (filteredValues.length === 0 && search)">
                            <span class="multiselect__option">
                                <span class="multiSelect__option" :search="search">No label found. Changing the search query.</span>
                            </span>
                        </li>
                        <li v-if="isPlaceholderVisible">
                            <span class="multiSelect__option">List is empty.</span>
                        </li>
                    </ul>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
export default {
    name: "MultiSelect",
    props: {
        values      : {
            required: true,
        },
        preSelect   : {
            required: false,
        },
    },
    data() {
        return {
            labels          : this.preSelect ? this.preSelect : [],
            search          : '',
            pointer         : null,
            isOpen          : false,
            showNoResults   : true,
            closeOnSelect   : true,
        }
    },
    methods: {
        /**
         * Opens the multiselect’s dropdown.
         * Sets this.isOpen to TRUE
         */
        activate        : function () {
            /* istanbul ignore else */
            if (this.isOpen || this.disabled) return
            this.isOpen = true

            this.$nextTick(() => this.$refs.search && this.$refs.search.focus())
        },
        /**
         * Closes the multiselect’s dropdown.
         * Sets this.isOpen to FALSE
         */
        deactivate      : function () {
            /* istanbul ignore else */
            if (!this.isOpen) return
            this.isOpen = false

        },
        /**
         * Call this.activate() or this.deactivate()
         * depending on this.isOpen value.
         *
         * @fires activate || this#deactivate
         * @property {Boolean} isOpen indicates if dropdown is open
         */
        toggle          : function () {
            this.isOpen ? this.deactivate() : this.activate()
        },
        /**
         * Add the given option to the list of selected options
         * or sets the option as the selected option.
         * If option is already selected -> remove it from the results.
         *
         * @param  {Object||String||Integer} option to select|deselect
         */
        select          : function (option) {
            const isSelected = this.isSelected( option )

            if (isSelected) {
                this.removeElement( option )
                return
            }
            this.labels.push( option );

            this.pointer = null

            if (this.closeOnSelect) this.deactivate()
        },
        /**
         * Finds out if the given element is already present
         * in the result value
         * @param  {Object||String||Integer} option passed element to check
         * @returns {Boolean} returns true if element is selected
         */
        isSelected      : function (option) {
            let state = false

            this.labels.filter(value => {
                if( value['id'] === option['id'] && value['name'] === option['name'])
                    state = true;
            })

            return state;
            // return this.labels.includes( option );
        },
        /**
         * Removes the given option from the selected options.
         * Additionally checks this.allowEmpty prop if option can be removed when
         * it is the last selected option.
         *
         * @param {Object||String||Integer} option description
         * @param {boolean} shouldClose
         * @returns {type}        description
         */
        removeElement   : function (option, shouldClose = true) {
            const index = this.labels.indexOf(option);
            this.labels.splice(index, 1)

            if (this.closeOnSelect && shouldClose) this.deactivate()
        },
        /**
         * @param {Integer} index
         * @param {Object} option
         * @returns {Array}
         */
        highlight       : function (index, option) {
            return {
                'multiSelect__option--highlight': index === this.pointer,
                'multiSelect__option--selected' : this.isSelected(option)
            }
        },
        /**
         * Set the current pointer
         *
         * @param  {Integer} index to set current pointer
         */
        pointerSet (index) {
            this.pointer = index
        }
    },
    computed: {
        /** Computed styles **/
        multiSelect__input  : function (){
            if( !this.isOpen)
                return `display: none; width: 0px; position: absolute; padding: 0px;`
            if( this.isOpen)
                return `width: calc(100% - 5px - 2px)`
        },
        isPlaceholderVisible () {
            return !this.labels.length && !this.isOpen;
        },
        /** Search Filter **/
        filteredValues: function () {
            return this.values.filter(value => {
                return value['name'].toLowerCase().includes(this.search.toLowerCase())
            })
        }
    }
}
</script>

<style lang="scss">
.fade-enter {
    opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity .5s ease-out;
}

.fade-leave-to {
    opacity: 0;
}

.multiSelect {
    * {
        box-sizing: border-box;
    }
    margin: 0 auto 60px;
    .multiSelect-container {
        position    : relative;
        display     : block;
        width       : 100%;
        min-height  : 40px;
        text-align  : left;
        color       : #35495e;
        box-sizing  : content-box;
    }
    &__select {
        position        : absolute;
        display         : block;
        width           : 40px;
        height          : 38px;
        right           : 1px;
        top             : 1px;
        margin          : 0;
        padding         : 4px 8px;
        text-align      : center;
        transition      : transform .2s ease;
        line-height     : 16px;
        box-sizing      : border-box;
        text-decoration : none;
        cursor          : pointer;
        &:before {
            content     : "";
            position    : relative;
            right       : 0;
            top         : 65%;
            color       : #999;
            margin-top  : 4px;
            border      : {
                style: solid;
                width: 5px 5px 0;
                color: #999 transparent transparent;
            }
        }
    }
    &__tags {
        display     : block;
        min-height  : 40px;
        padding     : 8px 40px 0 8px;
        border      : {
            width   : 1px;
            style   : solid;
            color   : #e8e8e8;
            radius  : 5px;
        }
        background  : {
            color   : #fff;
        }
        font-size   : 14px;
        &-wrap{
            display     : inline-block;
        }

        .multiSelect__tag {
            position    : relative;
            display     : inline-block;
            max-width   : 100%;
            margin      : {
                bottom  : 5px;
                right   : 5px;
            }
            padding     : 4px 26px 4px 10px;
            background  : {
                color   : #008eff;
            }
            border      : {
                radius  : 5px;
                right   : 10px;
            }
            color       : #fff;
            line-height : 1;
            white-space : nowrap;
            overflow    : hidden;
            text-overflow: ellipsis;

            &-icon {
                position    : absolute;
                cursor      : pointer;
                top         : 0;
                bottom      : 0;
                margin      : {
                    left    : 7px;
                }
                right       : 0;
                font        : {
                    weight  : 700;
                    style   : normal;
                }
                width       : 22px;
                text-align  : center;
                line-height : 22px;
                transition  : all .2s ease;
                border      : {
                    radius  : 5px;
                    top     : {
                        left-radius: 0;
                    }
                    bottom  : {
                        left-radius: 0;
                    }
                }
                &:after {
                    content     : "\D7";
                    font-size   : 14px;

                }
                &:focus, &:hover {
                    &:after {
                        color   : #ffffff;
                    }
                    background  : {
                        color   : #006dc3;
                    }
                }
            }
        }
    }
    &__input {
        position    : relative;
        display     : inline-block;
        width       : 100%;
        min-height  : 20px;
        line-height : 20px;
        margin      : {
            bottom  : 8px;
        }
        padding     : {
            left    : 5px;
            top     : 2px;
        }
        border      : {
            style   : none;
            radius  : 5px;
        }
        background  : {
            color   : #ffffff;
        }
        transition  : border .1s ease;
        box-sizing  : border-box;
        vertical-align: top;

        &:active, &:visited, &:focus {
            border : {
                color: #a8a8a8
            }
            outline: none;
        }
    }
    &__content {
        position    : absolute;
        display     : block;
        background  : #fff;
        width       : 100%;
        max-height  : 240px;
        overflow    : auto;
        border      : {
            width   : 1px;
            style   : solid;
            color   : #e8e8e8;
            top     : none;
            bottom  : {
                left-radius : 5px;
                right-radius: 5px;
            }
        }
        z-index     : 3;
        -webkit-overflow-scrolling: touch;

        /* width */
        &::-webkit-scrollbar {
            width: 7px;
        }
        /* Track */
        &::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        /* Handle */
        &::-webkit-scrollbar-thumb {
            background  : {
                color   : #008eff;;
            }
        }
        /* Handle on hover */
        &::-webkit-scrollbar-thumb:hover {
            background: #0074d0;
        }

        &-wrapper {
            display         : inline-block;
            min-width       : 100%;
            margin          : 0;
            padding         : 0;
            list-style      : none;
            vertical-align  : top;
        }

    }
    &__element {
        display: block;
    }
    &__option {
        position        : relative;
        display         : block;
        min-height      : 40px;
        padding         : 12px;
        line-height     : 16px;
        text-decoration : none;
        text-transform  : none;
        vertical-align  : middle;
        cursor          : pointer;
        white-space     : nowrap;

        &--highlight {
            background  : {
                color   : #008eff;
            };
            outline     : none;
            color       : #ffffff;
        }
        &--selected {
            background  : {
                color   : #f3f3f3;
            }
            color       : #35495e;
            font-weight : 700;
            &:before {
                content     : "";
                position    : absolute;
                left        : 0;
                top         : 0;
                height      : 100%;
                width       : 5px;
                background  : {
                    color   : #008eff;
                }
            }
        }

        .label__name {
            display         : inline-block;
            margin-left     : 5px;
            vertical-align  : middle;
            float           : left;
        }
    }
    &__placeholder {
        display : inline-block;
        color   : #adadad;
        margin  : {
            bottom: 10px;
        }
        padding : {
            top : 2px;
            left: 5px;
        }
    }
    .multiSelect__option--highlight.multiSelect__option--selected {
        background  : {
            color   : #9a9a9a;
        }
        color       : #fff;
    }

    &--active {
        &:not(.multiSelect--above) .multiCelect__input,
        &:not(.multiSelect--above) .multiSelect__tags {
            border-bottom-left-radius : 0;
            border-bottom-right-radius: 0;
        }
        .multiSelect__select {
            transform: rotate(180deg);
        }
    }
}

</style>

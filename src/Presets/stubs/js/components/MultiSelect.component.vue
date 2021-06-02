<template>
    <div class="multiSelect"
         :class="{'multiSelect--active' : active }" @click="active = !active" style="width: 350px; margin: 0 auto;">
        <div class="multiSelect-container">
            <div class="multiSelect__select"></div>
            <div class="multiSelect__tags">
                <div class="multiSelect__tags-wrap">
                    <span v-for="(item, index) in labelList" class="multiSelect__tag">
                        <span>{{  item['label'] }}</span>
                        <i aria-hidden="true" tabindex="1" class="multiSelect__tag-icon" @click="remove( index )"></i>
                    </span>
                </div>
                <div class="multiSelect__spinner" style="display: none;"></div>
                <input name="labels" type="text" autocomplete="off" placeholder="Pick badges" tabindex="0" class="multiSelect__input" :style="multiSelect__input">
                <span v-if="labelList" class="multiSelect__placeholder">Pick badges</span>
            </div>
            <div tabindex="-1" class="multiSelect__content" :style="multiSelect__content">
                <ul class="multiSelect__content-wrapper">
                    <li v-if="!!values" v-for="(item, index) in values" class="multiSelect__element">
                        <span class="multiSelect__option"
                              @mouseover="hover = index;"
                              @mouseout="hover = false;"

                              :class="{'multiSelect__option--highlight': hover === index, 'multiSelect__option--selected': selected(item) === true }"
                              :key="index" @click="add( item )">
                            <span class="badge__name">{{ item['label'] }}</span>
                        </span>
                    </li>
                    <li v-else>
                        <span class="multiSelect__option">List is empty.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MultiSelect",
    props: {
        values: {},
    },
    data() {
        return {
            labelList: [],
            hover: false,
            active: false,
        }
    },
    methods: {
        add: function ( label ) {
            if(!this.selected(label))
                this.labelList.push(label);
        },
        remove: function ( index ) {
            this.labelList.splice(index, 1)
        },
        selected: function ( item ) {
            return this.labelList.includes( item );
        }
    },
    computed: {
        multiSelect__input: function (){
            if( this.active && this.labelList)
                return `width: 100%;`
            else if( this.active )
                return `width: 100%; position: absolute; padding: 0;`
            else
                return `width: 0;`
        },
        multiSelect__content: function (){
            if( this.active )
                return `max-height: 300px;`
            else
                return `display: none; max-height: 300px;`

        }
    }

}
</script>

<style lang="scss">
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
            display     : inline;
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
                color   : #41b883;
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
                }
                &:after {
                    content     : "\D7";
                    color       : #266d4d;
                    font-size   : 14px;

                }
                &:focus, &:hover {
                    &:after {
                        color   : #ffffff;
                    }
                    background  : {
                        color   : #369a6e;
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
        padding     : 0 0 0 5px;
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
        &-wrapper {
            display         : none;
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
                color   : #41b883;
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
        }

        .badge__name {
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
        }
    }
    .multiSelect__option--highlight.multiSelect__option--selected {
        background: #ff6a6a;
        color: #fff;
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
# Changelog

All notable changes to `LaravelMultiSelect` will be documented in this file.

## [2.0.0] - 2021-06-07
### Added
* Deactivate a selected label after selecting it again
* new Variables
    * showNoResults : boolean
    * closeOnSelect : boolean  
* new Methods
    * activate()
    * deactivate()
    * toggle()
    * select()
    * isSelected()
    * removeElement()
    * highlight()
    * pointerSet()

### Changed
* Changes of various variable names 
    * labelList -> labels
    * hover -> pointer
    * active -> isOpen
    
###Removed
* remove Methods
    * add()
    * remove()
    * selected()

###Fixed
* Fixed autofocus on search input after opening the dropdown

## [1.1.2] - 2021-06-06
### Added
- Usage information

### Changed
- Changed command for install

## [1.0.0] - 2021-06-02

### Added
- Everything

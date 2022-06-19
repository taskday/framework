import VAvatar from "@/components/VAvatar.vue";
import VBreadcrumb from "@/components/VBreadcrumb.vue";
import VBreadcrumbItem from "@/components/VBreadcrumbItem.vue";
import VButton from "@/components/VButton.vue";
import VCard from "@/components/VCard.vue";
import VCardAuth from "@/components/VCardAuth.vue";
import VComment from "@/components/VComment.vue";
import VCommentList from "@/components/VCommentList.vue";
import VConfirm from "@/components/VConfirm.vue";
import VContainer from "@/components/VContainer.vue";
import VDrawer from "@/components/VDrawer.vue";
import VDropdown from "@/components/VDropdown.vue";
import VDropdownButton from "@/components/VDropdownButton.vue";
import VDropdownDivider from "@/components/VDropdownDivider.vue";
import VDropdownItem from "@/components/VDropdownItem.vue";
import VDropdownItems from "@/components/VDropdownItems.vue";
import VFieldWrapper from "@/components/VFieldWrapper.vue";
import VFormCheckbox from "@/components/VFormCheckbox.vue";
import VFormHtmlEditor from "@/components/VFormHtmlEditor.vue";
import VFormInput from "@/components/VFormInput.vue";
import VFormSection from "@/components/VFormSection.vue";
import VFormSelect from "@/components/VFormSelect.vue";
import VFormErrors from "@/components/VFormErrors.vue";
import VFormList from "@/components/VFormList.vue";
import VFormEdit from "@/components/VFormEdit.vue";
import VIcon from "@/components/VIcon.vue";
import VLink from "@/components/VLink.vue";
import VMentionsList from "@/components/VMentionsList.vue";
import VModal from "@/components/VModal.vue";
import VNav from "@/components/VNav.vue";
import VNavLink from "@/components/VNavLink.vue";
import VPageTitle from "@/components/VPageTitle.vue";
import VRoom from "@/components/VRoom.vue";
import VSearch from "@/components/VSearch.vue";
import VTable from "@/components/VTable.vue";
import VTableBody from "@/components/VTableBody.vue";
import VTableCell from "@/components/VTableCell.vue";
import VTableHead from "@/components/VTableHead.vue";
import VTableHeading from "@/components/VTableHeading.vue";
import VTableRow from "@/components/VTableRow.vue";
import VTabs from "@/components/VTabs.vue";
import VTabsItem from "@/components/VTabsItem.vue";
import VTabsList from "@/components/VTabsList.vue";
import VTabsPanel from "@/components/VTabsPanel.vue";
import VTabsPanels from "@/components/VTabsPanels.vue";

import useField from "./composables/useField";
import useSorter from "./composables/useSorter";
import useCardForm from "./composables/useCardForm";

import PageCardsShow from "./views/Cards/Show.vue";

class Taskday implements TaskdayInterface {

  version = '0.1.0';

  readonly fields = {};

  readonly filters = {};

  readonly options = {};

  readonly actions = {};

  public views = [];

  public widgets = {};

  private instance;

  constructor(instance) {
    this.instance = instance;
  }

  registerField(namespace, component) {
    this.fields[namespace] = component;
    this.instance.component(`${namespace}-field`, component);
  }

  registerFilter(namespace, component) {
    this.filters[namespace] = component;
    this.instance.component(`${namespace}-filter`, component);
  }

  registerOptions(namespace, component) {
    this.options[namespace] = component;
    this.instance.component(`${namespace}-options`, component);
  }

  registerAction(namespace, component) {
    this.actions[namespace] = component;
    this.instance.component(`${namespace}-action`, component);
  }

  registerViews(namespace, views: any[]) {
    this.views = [ ...this.views, ...views ];
    views.forEach(view => this.instance.component(`${namespace}-view`, view))
  }

  registerWidgets(components) {
    this.widgets = { ...this.widgets, ...components };
    Object.keys(this.widgets).map(k => {
      this.instance.component(`${k}`, this.widgets[k]);
    })
  }

  register(namespace, components) {
    if (components.field) {
      this.registerField(namespace, components.field);
    }
    if (components.filter) {
      this.registerFilter(namespace, components.filter);
    }
    if (components.options) {
      this.registerOptions(namespace, components.options);
    }
    if (components.views) {
      this.registerViews(namespace, components.views);
    }
    if (components.action) {
      this.registerAction(namespace, components.action);
    }
    if (components.widgets) {
      this.registerWidgets(components.widgets);
    }
  }
}

export {
  Taskday,
  PageCardsShow,
  useField,
  useSorter,
  useCardForm,
  VAvatar,
  VBreadcrumb,
  VBreadcrumbItem,
  VButton,
  VCard,
  VCardAuth,
  VComment,
  VCommentList,
  VConfirm,
  VContainer,
  VDrawer,
  VDropdown,
  VDropdownButton,
  VDropdownDivider,
  VDropdownItem,
  VDropdownItems,
  VFieldWrapper,
  VFormCheckbox,
  VFormHtmlEditor,
  VFormInput,
  VFormSection,
  VFormSelect,
  VFormErrors,
  VFormEdit,
  VFormList,
  VIcon,
  VLink,
  VMentionsList,
  VModal,
  VNav,
  VNavLink,
  VPageTitle,
  VRoom,
  VSearch,
  VTable,
  VTableBody,
  VTableCell,
  VTableHead,
  VTableHeading,
  VTableRow,
  VTabs,
  VTabsItem,
  VTabsList,
  VTabsPanel,
  VTabsPanels,
}

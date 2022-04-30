interface User {
  id: number;
  name: string;
  email: string;
  password: string;
  created_at: string;
  updated_at: string;
  profile_photo_url: string;
}


interface Member<T> {
  id: string
  user: User
  memberable: T
  updated_at: string
  created_at: string
}

interface Workspace {
  id: number;
  title: string;
  description: string;
  projects: Project[];
  members: Member<Workspace>[];
}

interface Project {
  id: number;
  title: string;
  description: string;
  workspace: Workspace
  fields: Field[]
  customFields: any
  cards: Card[];
  members: Member<Project>[];
}

interface Card {
  id: string;
  title: string;
  content: string;
  comments: Comment[];
  fields: Field[];
  customFields: any;
  project: Project;
}

interface Field {
  id: string;
  title: string;
  handle: string;
  type: string;
  options: Object
  pivot: {
    value: string;
  }
}

interface Comment {
  id: number;
  content: string;
}

interface Pagination<Type> {
  data: Type[];
}

interface Breadcrumb {
  title: String;
  url?: String;
}

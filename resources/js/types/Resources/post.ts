import { User } from "./user";

export type Post = {
  id: number;
  title: string;
  body: string;
  user_id: number;
  created_at: string;
  updated_at: string;
  user: User;
};


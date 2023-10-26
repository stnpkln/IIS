/** source/controllers/posts.ts */
import { Request, Response, NextFunction } from "express";

interface Post {
  userId: Number;
  id: Number;
  title: String;
  body: String;
}

// getting all posts
const getPosts = async (req: Request, res: Response, next: NextFunction) => {
  return res.status(200).json({
    message: "you called get posts",
  });
};

// getting a single post
const getPost = async (req: Request, res: Response, next: NextFunction) => {
  let id: string = req.params.id;
  return res.status(200).json({
    message: `you called get post with id: ${id}`,
  });
};

// updating a post
const updatePost = async (req: Request, res: Response, next: NextFunction) => {
  let id: string = req.params.id;
  let title: string = req.body.title ?? null;
  let body: string = req.body.body ?? null;
  return res.status(200).json({
    message: `you called update post with id: ${id}, title: ${title}, body: ${body}`,
  });
};

// deleting a post
const deletePost = async (req: Request, res: Response, next: NextFunction) => {
  let id: string = req.params.id;
  return res.status(200).json({
    message: `you called delete post with id: ${id}`,
  });
};

// adding a post
const addPost = async (req: Request, res: Response, next: NextFunction) => {
  // get the data from req.body
  let title: string = req.body.title;
  let body: string = req.body.body;
  return res.status(200).json({
    message: `you called add post with title: ${title}, body: ${body}`,
  });
};

export default { getPosts, getPost, updatePost, deletePost, addPost };

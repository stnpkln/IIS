/** source/controllers/posts.ts */
import { Request, Response, NextFunction } from "express";
import { Client } from "pg";
import { dbConfig } from "../config";

const client = new Client(dbConfig);

interface Post {
  userId: Number;
  id: Number;
  title: String;
  body: String;
}

// getting all posts
const getPosts = async (req: Request, res: Response, next: NextFunction) => {
  client.connect(function (err) {
    if (err) throw err;
    console.log("Connected!");
  });
  const queryString = "SELECT * FROM posts";
  const result = await client.query({ text: queryString });
  const rows: Post[] = result.rows;
  if (rows) {
    return res.status(200).json({
      message: "you called get posts",
      data: rows,
    });
  }
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

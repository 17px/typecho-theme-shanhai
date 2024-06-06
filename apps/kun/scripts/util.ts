import fs from "fs";

/**
 * walk module
 * @param {string} folderPath root dir
 */
export const getModules = (folderPath: string) => {
  try {
    const filesAndDirs = fs.readdirSync(folderPath, { withFileTypes: true });
    const dirs = filesAndDirs
      .filter((dir) => dir.isDirectory())
      .map((dir) => dir.name);
    return dirs;
  } catch (error) {
    console.error("Error reading directory:", error);
    return [];
  }
};

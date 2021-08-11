"use strict";
const path = require("path");
const assert = require("yeoman-assert");
const helpers = require("yeoman-test");
describe("generator-slimphp:app", () => {
  beforeAll(() => {
    return helpers
      .run(path.join(__dirname, "../generators/app"))
      .withPrompts({ apptype: "3all" });
  });
  it("dummy", () => {
    assert.equal(true, 1);
  });
  // It("creates files", () => {
  //   assert.file(["package.json"]);
  // });
});
